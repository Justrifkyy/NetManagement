<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\SurveyForm;
use App\Models\InstallationForm;
use App\Models\DeviceConfig;
use App\Models\NetworkConfig;
use App\Models\InternetAccount;
use App\Models\ConnectionTest;
use App\Models\HandoverConfirmation;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $today_tasks = InstallationForm::where('installation_date', today())->count();
        $pending_installations = InstallationForm::whereNull('installation_status')->count();
        $repair_tickets = Ticket::where('type', 'repair')->where('status', 'open')->count();

        return view('technician.dashboard', compact('today_tasks', 'pending_installations', 'repair_tickets'));
    }

    // Survey Management
    public function survey_list()
    {
        $surveys = SurveyForm::with('lead', 'technician')->latest()->paginate(15);
        return view('technician.survey.index', compact('surveys'));
    }

    // Get Available Leads for Survey (tidak punya SurveyForm)
    public function available_surveys_list()
    {
        $available_leads = Lead::whereDoesntHave('survey')
            ->with('package', 'marketing')
            ->whereIn('status', ['prospect', 'contacted', 'qualified'])
            ->latest()
            ->paginate(15);

        return view('technician.surveys.index', compact('available_leads'));
    }

    // Get Available Leads for Installation (tidak punya InstallationForm)
    public function available_installations_list()
    {
        $available_leads = Lead::whereDoesntHave('installation')
            ->whereHas('survey', function ($q) {
                $q->where('survey_status', 'layak');
            })
            ->with('package', 'marketing', 'survey')
            ->latest()
            ->paginate(15);

        return view('technician.installations.index', compact('available_leads'));
    }

    public function survey_create($lead_id)
    {
        $lead = Lead::findOrFail($lead_id);
        $survey = SurveyForm::where('lead_id', $lead_id)->first() ?? new SurveyForm();
        return view('technician.survey.create', compact('lead', 'survey'));
    }

    public function survey_store(Request $request, $lead_id)
    {
        $lead = Lead::findOrFail($lead_id);
        
        $validated = $request->validate([
            'survey_status' => 'required|in:layak,tidak_layak',
            'survey_date' => 'required|date',
            'survey_result' => 'required|string',
            'location_challenge' => 'nullable|string',
            'location_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('location_photo')) {
            $path = $request->file('location_photo')->store('surveys/'.$lead->id, 'public');
            $validated['location_photo_path'] = $path;
        }

        $validated['technician_id'] = Auth::id();

        SurveyForm::updateOrCreate(['lead_id' => $lead_id], $validated);

        return redirect()->route('technician.survey.index')->with('success', 'Survey berhasil disimpan');
    }

    // Installation Management
    public function installation_list()
    {
        $installations = InstallationForm::with('lead', 'technician')->latest()->paginate(15);
        return view('technician.installation.index', compact('installations'));
    }

    public function installation_create($lead_id)
    {
        $lead = Lead::findOrFail($lead_id);
        $installation = InstallationForm::where('lead_id', $lead_id)->first() ?? new InstallationForm();
        return view('technician.installation.create', compact('lead', 'installation'));
    }

    public function installation_store(Request $request, $lead_id)
    {
        $lead = Lead::findOrFail($lead_id);

        $validated = $request->validate([
            'installation_date' => 'required|date',
            'connection_type' => 'required|in:fiber,wireless',
            'cable_length' => 'required|integer|min:0',
            'device_placement' => 'required|string',
            'installation_status' => 'required|in:berhasil,gagal',
            'installation_notes' => 'nullable|string',
        ]);

        $validated['technician_id'] = Auth::id();

        $installation = InstallationForm::updateOrCreate(['lead_id' => $lead_id], $validated);

        return redirect()->route('technician.installation.show', $installation)->with('success', 'Instalasi berhasil disimpan');
    }

    // Device Configuration
    public function device_form($installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);
        $device = $installation->deviceConfig() ?? new DeviceConfig();
        return view('technician.installation.device', compact('installation', 'device'));
    }

    public function device_store(Request $request, $installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);

        $validated = $request->validate([
            'device_type' => 'required|string|max:100',
            'device_brand' => 'required|string|max:100',
            'serial_number' => 'required|string|max:100|unique:device_configs,serial_number',
            'mac_address' => 'required|string|max:50',
            'device_condition' => 'required|in:baru,baik,rusak_ringan,rusak_berat',
        ]);

        $validated['installation_id'] = $installation_id;
        $validated['lead_id'] = $installation->lead_id;

        DeviceConfig::updateOrCreate(['installation_id' => $installation_id], $validated);

        return redirect()->route('technician.network.form', $installation_id)->with('success', 'Data perangkat berhasil disimpan');
    }

    // Network Configuration
    public function network_form($installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);
        $network = $installation->networkConfig() ?? new NetworkConfig();
        return view('technician.installation.network', compact('installation', 'network'));
    }

    public function network_store(Request $request, $installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);

        $validated = $request->validate([
            'router_area' => 'required|string|max:100',
            'port_interface' => 'required|string|max:50',
            'vlan_id' => 'nullable|string|max:50',
            'olt_access_point' => 'required|string|max:100',
            'connection_mode' => 'required|in:pppoe,static_ip,dhcp',
        ]);

        $validated['installation_id'] = $installation_id;
        $validated['lead_id'] = $installation->lead_id;

        NetworkConfig::updateOrCreate(['installation_id' => $installation_id], $validated);

        return redirect()->route('technician.internet-account.form', $installation_id)->with('success', 'Konfigurasi jaringan berhasil disimpan');
    }

    // Internet Account
    public function internet_account_form($installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);
        $account = InternetAccount::where('installation_id', $installation_id)->first() ?? new InternetAccount();
        return view('technician.installation.internet-account', compact('installation', 'account'));
    }

    public function internet_account_store(Request $request, $installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);

        $validated = $request->validate([
            'pppoe_username' => 'nullable|string|max:100',
            'pppoe_password' => 'nullable|string|max:100',
            'service_package' => 'required|string|max:100',
            'initial_service_status' => 'required|in:aktif,tidak_aktif,suspend',
        ]);

        $validated['installation_id'] = $installation_id;
        $validated['lead_id'] = $installation->lead_id;

        InternetAccount::updateOrCreate(['installation_id' => $installation_id], $validated);

        return redirect()->route('technician.connection-test.form', $installation_id)->with('success', 'Akun internet berhasil disimpan');
    }

    // Connection Test
    public function connection_test_form($installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);
        $test = $installation->connectionTest() ?? new ConnectionTest();
        return view('technician.installation.connection-test', compact('installation', 'test'));
    }

    public function connection_test_store(Request $request, $installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);

        $validated = $request->validate([
            'connection_status' => 'required|in:berhasil,gagal',
            'speed_test_download' => 'nullable|numeric|min:0',
            'speed_test_upload' => 'nullable|numeric|min:0',
            'latency' => 'nullable|integer|min:0',
            'test_result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('test_result_photo')) {
            $path = $request->file('test_result_photo')->store('connection-tests/'.$installation->lead_id, 'public');
            $validated['test_result_photo_path'] = $path;
        }

        $validated['installation_id'] = $installation_id;
        $validated['lead_id'] = $installation->lead_id;

        ConnectionTest::updateOrCreate(['installation_id' => $installation_id], $validated);

        return redirect()->route('technician.handover.form', $installation_id)->with('success', 'Uji koneksi berhasil disimpan');
    }

    // Handover Confirmation
    public function handover_form($installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);
        $handover = $installation->handoverConfirmation() ?? new HandoverConfirmation();
        return view('technician.installation.handover', compact('installation', 'handover'));
    }

    public function handover_store(Request $request, $installation_id)
    {
        $installation = InstallationForm::findOrFail($installation_id);

        $validated = $request->validate([
            'internet_active_confirmation' => 'required|boolean',
            'handover_date' => 'required|date',
            'final_technician_notes' => 'nullable|string',
        ]);

        $validated['installation_id'] = $installation_id;
        $validated['lead_id'] = $installation->lead_id;
        $validated['technician_id'] = Auth::id();

        HandoverConfirmation::updateOrCreate(['installation_id' => $installation_id], $validated);

        return redirect()->route('technician.installation.index')->with('success', 'Serah terima berhasil disimpan');
    }

    // Installation Detail
    public function installation_show($installation_id)
    {
        $installation = InstallationForm::with([
            'lead',
            'deviceConfig',
            'networkConfig',
            'connectionTest',
            'handoverConfirmation'
        ])->findOrFail($installation_id);

        return view('technician.installation.show', compact('installation'));
    }
}
