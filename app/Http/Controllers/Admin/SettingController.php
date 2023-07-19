<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function logo(){
        return view('admin.setting.create');
    }
    public function change_logo(Request $request){
        
        $setting = Setting::first() ??  new Setting;

        if($request->hasFile('image')){
            if(isset($setting->logo)){
                $logo_path = public_path('storage/'.$setting->logo);
                if(file_exists($logo_path)){
                    unlink($logo_path);
                }
            }
            $path = $request->file('image')->store('images/setting','public');
            $setting->logo = $path;
        }

        if($setting->save()){
            return redirect()->route('dashboard');
        }
    }
}
