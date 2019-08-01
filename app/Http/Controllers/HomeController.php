<?php namespace App\Http\Controllers;

use Input;
use Crypt;
use Carbon\Carbon;
use App\Jobs;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;
class HomeController extends Controller
{
	/*
	  |--------------------------------------------------------------------------
	  | Home Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller renders your application's "dashboard" for users that
	  | are authenticated. Of course, you are free to change or remove the
	  | controller as you wish. It is just here to get your app started!
	  |
	 */

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    
	public function __construct()
	{
		$this->officeArray = [];
		$my_user = Auth::user()->id;
		$user = \App\User::where('id', $my_user)->with('offices')->first();
		foreach ($user->offices as $of) {
			$this->officeArray[] = $of->id;
		}

	}


	/**
	 * Show the application dashboard to the user.
	 *
	 * 
	 */

	public function index()
	{


		$offices = \App\Office::orderBy('officeName', 'ASC')->orderBy('officeName', 'ASC')->get();
		$officeData = new \stdClass();
		$officeData->count = $offices->count();
		$left = ceil($officeData->count / 2);
		$right = floor($officeData->count / 2);
		$index = 0;

		for ($i = 0; $i < $officeData->count; $i++) {
			if ($i < $left) {
				$officeData->left[] = $offices[$i];
			} else {
				$officeData->right[] = $offices[$i];
			}
		}


		$actOffice = \App\ActOffice::whereIn('office_id', $this->officeArray)->select('account_id')->get();
		$accessableOffices = [];
		foreach ($actOffice as $ao) {
			$accessableOffices[] = $ao->account_id;
		}
		// $data['actActive'] = \App\Account::distinct()->whereIn('id', $accessableOffices)->whereHas('actStatus', function ($query) {
		//	$query->where('status_id', 0);
		//})->count();

        $data['actActive'] = 6028;
		$data['offices'] = $offices;
        //dd($officeData->count);
		\DB::connection()->enableQueryLog();
		$materials = \App\Material::all(['id', 'cost']);
		$mats = \App\Material::all();
		$now = Carbon::today();
		$startOfmonth = $now->startOfMonth();
//Luiz
//		$monthService = \App\FieldService::whereBetween('service_date', array(date('Y-m-01'), date('Y-m-t')))->with('fieldData')->get();
		$monthService = \App\FieldService::where('service_date', date('Y-m-01'))->with('fieldData')->get();
//Luiz

		$mat_total = 0;
		$mat_cost = 0;
		foreach ($monthService as $ms) {
			foreach ($ms->fieldData as $fd) {
				$mat_total += $fd->quantity;
				//$mat_cost += ($fd->quantity * $materials->find($fd->material_id)->cost);
			}
		}


		$materials->number = $monthService->count();
		$materials->total = $mats->count();
		$materials->units = $mat_total;
		$materials->cost = $mat_cost;
		$data['materials'] = $materials;
		$tmpState = \App\TaxDistrict::distinct()->select('state_id')->get();
		$temp = [];
		foreach($tmpState as $ts){
			$temp[] = $ts->id;
		}
		$data['states'] = \App\State::whereIn('id', $tmpState)->get();
		$data['tech'] = \App\Technician::orderBy('code', 'asc')->get();
		$data['salesman'] = \App\Salesman::orderBy('name', 'asc')->get();
		$data['officesData'] = $officeData;

		$data['monthHours'] = \App\FieldService::where('service_date', '>=', Carbon::now()->startOfMonth())->sum('hours');
		$data['totalHours'] = \App\FieldService::sum('hours');


		$data['perms'] = \App\Permission::all();
		//$data['actInactive'] = \App\Account::distinct()->whereIn('id', $accessableOffices)->whereHas('actStatus', function ($query) {
        //$query->where('status_id', '<>', 0);
		//})->count();
        $data['actInactive'] = 5042;
		//$data['actCount'] = \App\Account::distinct('account_id')->whereIn('id', $accessableOffices)->count();
        $data['actCount'] = 11070;
		$data['fire'] = 'lister';
		$data['bc'] = 'Main Menu';
		$data['userLevels'] = \App\UserLevel::all();
		$data['users'] = \App\User::orderBy('last_name', 'ASC')->get();
		$my_id = \Auth::user()->id;
		$me = \App\User::where('id', $my_id)->with('permissions')->first();
		$perms = [];
		foreach ($me->permissions as $p) {
//			echo "permission:".$p->id;
			$perms[$p->id] = true;
		}


		$perms['sa'] = ($me->is_super_admin ? true : false);
		$data['me'] = $perms;

		//tech count
		$active = \App\Technician::where('active', true)->get();
		$inactive = \App\Technician::where('active', false)->get();
		$data['active'] = $active->count();
		$data['inactive'] = $inactive->count();


//		dd('data ', $data['me']);
//        dd($data['offices']);



		return view('dash.dash', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));

	}

	public function autolookup()
	{
		$input = Input::all();
		$act = config('lookup_accounts.account_auto');
		$return['query'] = $input['query'];
		$return['suggestions'] = array();

		foreach ($act as $a):
			if (strpos($a['act_no'], $input['query']) !== false):
				array_push($return['suggestions'], ['value' => $a['act_no'] . " - " . $a['act_name'], 'data' => $a['act_no']]);
				continue;
			elseif (strpos(strtolower($a['act_name']), $input['query']) !== false):
				array_push($return['suggestions'], ['value' => $a['act_name'] . " - " . $a['act_no'], 'data' => $a['act_no']]);
			endif;
		endforeach;

		return json_encode($return);
	}

	public function autolookupTech()
	{
		$input = Input::all();
		$act = config('lookup_techs.offices');
		$return['query'] = $input['query'];
		$return['suggestions'] = array();

		foreach ($act as $a):
			if (strpos($a['value'], $input['query']) !== false):
				array_push($return['suggestions'], ['value' => $a['act_no'] . " - " . $a['act_name'], 'data' => $a['act_no']]);
				continue;
			elseif (strpos(strtolower($a['label']), $input['query']) !== false):
				array_push($return['suggestions'], ['value' => $a['act_name'] . " - " . $a['act_no'], 'data' => $a['act_no']]);
			endif;
		endforeach;

		return json_encode($return);
	}

	public function autoselect()
	{
		$input = Input::all();
		$act = config('lookup_accounts.accounts');

		foreach ($act as $a):
			if ($a['act_number'] == $input['query']):
				foreach ($a as $key => $val):
					$return [$key] = $val;
				endforeach;
			endif;
		endforeach;

		return json_encode($return);
	}

	public function mailform()
	{


		return view('dash.mailform')
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}

	public function gomailform()
	{
		$input = Input::all();
		// create curl resource
		$ch = curl_init();

		// set url
		curl_setopt($ch, CURLOPT_URL, "http://192.168.56.104/testphp.php");

		curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		if ($data['input'] = curl_exec($ch)):
		else:
			$data['input'] = 'baddly';
			$data['error'][] = error_get_last();
		endif;
		// close curl resource to free up system resources
		curl_close($ch);
		$data['error'][] = error_get_last();
		$data['input'] = json_decode($data['input']);

		return view('dash.mailform', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}

	public function editform()
	{
		$data['submitted'] = 'hidden';
		return view('dash.edit', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}

	public function editformpost()
	{
		$data = [];
		$input = Input::all();
		$data['submitted'] = "hidden";
		return view('dash.edit', $data)
			->withEncryptedCsrfToken(Crypt::encrypt(csrf_token()));
	}

	public function editGet()
	{

		$data['superCats'] = Jobs::all(); //config ( 'test_job.jobs' );
		return json_encode($data);
	}

	public function editDelete()
	{
		$input = Input::all();
		$data['bob'] = Jobs::where('id', '=', $input['id'])->get();
		File::Delete(public_path() . '/docs/' . $data['bob'][0]->fname);
		$data['fire'] = Jobs::where('id', '=', $input['id'])->delete();
		return json_encode($data);
	}

	public function editFile(Request $request)
	{
//        $file = Request::file ( 'file' );
//		$extension = $file->getClientOriginalExtension();
//		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

		$extension = Input::file('file')->getClientOriginalExtension(); // getting image extension

		$trueName = Input::file('file')->getClientOriginalName();

		do {

			$fileName = rand(11111, 9999999) . '.' . $extension; // renameing image

		} while (File::exists(public_path() . '/docs/' . $fileName));


		//check for file.
		$newJob = new Jobs(array(
			"name" => $trueName,
			"fname" => $fileName,
			"title" => Input::get('title'),
			"group" => Input::get('group')
		));
		$newJob->save();

		//move file
		Input::file('file')->move(public_path() . '/docs/', $fileName); // uploading file to given path


		return json_encode(["error" => "good"
			, "title" => Input::get('title')
			, "group" => Input::get('group')
			, "newJob" => $newJob->id
			, "fname" => $fileName, "name" => $trueName]);
	}

}
