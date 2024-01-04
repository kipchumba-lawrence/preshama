<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Route;
use App\Models\UserApp;
use App\Models\customer;
use App\Models\SalesRep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CustomersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->user_type == 'Admin') {
            // $users = Customer::all();
            $users = UserApp::where('user_type', 'USER')->where('is_active',1)->get();
            return view('admin.customers.show', compact('users'));
        } else {
            return redirect()->route('home');
        }
    }
    public function index_sales()
    {
        if (Auth::user()->user_type == 'Admin') {
            $users = UserApp::where('user_type', 'SALES_REP')->where('is_active',1)->get();
            return view('admin.customers.show_rep', compact('users'));
        } else {
            return redirect()->route('home');
        }
    }

    public function index_app()
    {
        if (Auth::user()->user_type == 'Admin') {

            $users =  UserApp::leftJoin('customer', 'users_app.customer_id', '=', 'customer.customer_id')
                ->select('users_app.*', 'customer.customer_no')
                ->orderBy('users_app.user_type', 'ASC')
                ->orderBy('users_app.first_name', 'ASC')
                ->get();

            return view('admin.customers.show', compact('users'));
        } else {
            return redirect()->route('home');
        }
    }


    public function create()
    {
        if (Auth::user()->user_type == 'Admin') {
            $sales_managers = User::where('user_type', 'Sales Manager')->get();
            $routes = Route::all();
            return view('admin.customers.create', compact('sales_managers', 'routes'));
        } else {
            return redirect()->route('home');
        }
    }

    public function create_app_user()
    {
        if (Auth::user()->user_type == 'Admin') {
            $sales_managers = User::where('user_type', 'Sales Manager')->get();
            $routes = Route::all();
            return view('admin.customers.create-app-user', compact('sales_managers', 'routes'));
        } else {
            return redirect()->route('home');
        }
    }
    public function create_customer_user()
    {
        if (Auth::user()->user_type == 'Admin') {
            $sales_managers = User::where('user_type', 'Sales Manager')->get();
            $routes = Route::all();
            return view('admin.customers.create-app-customer', compact('sales_managers', 'routes'));
        } else {
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|max:100',
            'lname' => 'required|max:100',
            'user_type' => 'required',
            'pin' => 'required',
            'mobileno' => 'required',
            'customerno' => ['nullable', 'string', 'required_if:user_type,USER'],
            'email' => ['required', 'email'],
        ]);

        $customer_id = null;

        if ($request->customerno != '') {
            $customer = DB::table('customer')->where('customer_no', $request->customerno)->get();

            foreach ($customer as $row) {
                $customer_id = $row->customer_id;
            }
        }

        $user = new UserApp();
        $user->user_type = $request->user_type;
        $user->customer_id = $customer_id;
        $user->first_name = $request->fname;
        $user->surname = $request->lname;
        $user->username = $request->email;
        $user->pin = $request->pin;
        $user->email = $request->email;
        $user->mobileno = $request->mobileno;
        $user->save();

        if ($request->user_type !== 'USER') {
            // Save a copy to the sales_person table
            $salesPerson = new SalesRep();
            $salesPerson->first_name = $request->fname;
            $salesPerson->last_name = $request->lname;
            $salesPerson->mobile_no = $request->mobileno;
            $salesPerson->email = $request->email;
            $salesPerson->save();
        }

        return redirect()->back()->with('success', "$request->fname successfully registered");
    }
    // Find out how the rep id is assigned and how clients are onboaded on the app.

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = UserApp::find($id)->first();
        return view('admin.customers.edit-app-user', compact('user'));
    }

    public function update_app_user(Request $request, $id)
    {
        $this->validate($request, [
            'fname' => 'required|max:100',
            'lname' => 'required|max:100',
            'user_type' => 'required',
            'pin' => 'required',
            'mobileno' => 'required',
            'customerno' => ['nullable', 'string', 'required_if:user_type,USER'],
            'email' => ['required', 'email']
        ]);

        $customer_id = null;

        if ($request->customerno != '') {
            $customer = DB::table('customer')->where('customer_no', $request->customerno)->get();

            foreach ($customer as $row) {
                $customer_id = $row->customer_id;
            }
        }

        //update the application
        $user = UserApp::where('user_id', $request->get('app_user_id'))
            ->update([
                'user_type' => $request->get('user_type'),
                'customer_id' => $customer_id,
                'first_name' => $request->get('fname'),
                'surname' => $request->get('lname'),
                'pin' => $request->get('pin'),
                'mobileno' => $request->get('mobileno'),
                'username' => $request->get('email'),
                'email' => $request->get('email'),
            ]);


        return redirect()->back()->with('success', "$request->fname successfully updated");
    }

    public function destroy($id)
    {
        $user = UserApp::where('user_id', $id)->first();
        $user->is_active = 0;
        $user->save();
        return redirect()->back()->with('success', "Successfully disbled");
    }
   public function updateCustomersCredit()
   {
       // Add the JSON header to test
   
       try {
           $curl = curl_init();
   
           curl_setopt_array($curl, array(
               CURLOPT_URL => 'http://api.sajsoft.co.ke:96/api/customers/customers.php',
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'GET',
               CURLOPT_HTTPHEADER => array(
                   'Content-Type: application/json'
               ),
           ));
   
           $response = curl_exec($curl);
           curl_close($curl);
           dd($response);
   
           if ($response) {
               $apiData = json_decode($response, true);
   
               foreach ($apiData as $data) {
                   $customer = Customer::where('customer_code', $data['code'])->first();
   
                   if ($customer) {
                       $customer->credit_limit = $data['creditlimit'];
                       $customer->credit_exposure = $data['bal'];
                       $customer->save();
                   }
               }
   
               Log::channel('customlog')->info('Customers credit updated successfully.');
               return response()->json(['message' => 'Customers credit updated successfully.']);
           } else {
               Log::channel('customlog')->error('Failed to fetch data from the API.');
               return response()->json(['error' => 'Failed to fetch data from the API.'], 500);
           }
       } catch (\Exception $e) {
           Log::channel('customlog')->error('Update customer credit failed: ' . $e->getMessage());
           return response()->json(['error' => 'An error occurred while updating customers credit: ' . $e->getMessage()], 500);
       } catch (\Error $e) {
           Log::channel('customlog')->error('Error updating customer credit: ' . $e->getMessage());
           return response()->json(['error' => 'An error occurred while updating customers credit: ' . $e->getMessage()], 500);
       }
   }
}
