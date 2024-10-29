<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function settings()
    {

        // $setting = Setting::orderBy('id', 'DESC')->where('key', 'site_settings')->first();

        // if ($setting) {
        //     $settings = json_decode($setting->value, true);
        // } else {
        //     $settings = [];
        // }
        // return view('setting', compact('settings'));
        return view('setting2');
        echo 'hi';
    }
    public function savesettings(Request $request, $id = 0)
    {
        // $settings = Setting::orderBy('id', 'DESC')->where('key', 'site_settings')->first(); // Get the latest settings row

        // // If settings row doesn't exist, create a new one
        // if (!$settings) {
        //     $settings = new Setting;
        // }

        // $req = $request->except('_token');
        // if (!empty($request->password)) {
        //     $password = Hash::make($request->password);
        //     $req['password'] = $password;
        // }

        // $settings->key = 'site_settings';
        // $settings->category = 'settings';
        // $settings->value = json_encode($req);

        // $settings->save();
        return redirect()->back()->withSuccess('Settings have been successfully updated!');
    }
}
