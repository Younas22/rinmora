<?php
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Str;


if (!function_exists('all_users')) {
    
        function all_users($hr_id)
        {
            $all_users = DB::table('users')
            ->select()
            ->where('hr_id', $hr_id)
            ->where('roll','!=', 'hr')
            ->get();

            $html = "";
            $html .= "<option value=''>Select User</option>";
            foreach ($all_users as $key) {
                    $html .= "<option value=".$key->id.">".$key->name."</option>";
            }
            $html .= "";
            return $html;
        }
}


if (!function_exists('total_taskFiles')) {
    
        function total_taskFiles($task_id)
        {
            $total_taskFiles = DB::table('documents')
            ->select()
            ->where('task_id', $task_id)
            ->count();
            return $total_taskFiles;
        }
}

if (!function_exists('userIncentive')) {
    
        function userIncentive($user_id)
        {
            $userIncentive = DB::table('incentive')
            ->select()
            ->where('user_id', $user_id)
            ->get();
            return $userIncentive;
        }
}

if (!function_exists('lmt')) {
    
        function lmt($body, $limit)
        {
            return Str::limit($body, $limit);
        }
}


if (!function_exists('str_slug')) {
    
        function str_slug($name,$text)
        {
            return url(Str::slug($name).'/'.Str::slug($text));
        }
}


if (!function_exists('generateOrderID')) {
    
    function generateOrderID() {
        return 'O_'.rand(10000, 99999);
    }
}

if (!function_exists('get_cost')) {
        function get_cost($item_id)
        {
            $get_cost = DB::table('products_detials')
            ->where('id', $item_id)
            ->first();
            return $get_cost->price;
        }
}

if (!function_exists('get_product_name')) {
        function get_product_name($main_pro_id)
        {
            $get_product_name = DB::table('products')
            ->where('id', $main_pro_id)
            ->first();
            return $get_product_name->name;
        }
}

if (!function_exists('check_user_attendance')) {
    
        function check_user_attendance($date,$user_id)
        {
            $attendances = DB::table('attendances')
            ->where('user_id', $user_id)
            ->where('date', $date)
            ->first();
            // dd($attendances);
            return $attendances;
        }
}

if (!function_exists('check_user_break')) {
    
        function check_user_break($date,$user_id)
        {
            $break = DB::table('break')
            ->where('user_id', $user_id)
            ->where('status', 0)
            ->where('date', $date)
            ->first();
            return $break;
        }
}

if (!function_exists('check_user_breaks')) {
    
        function check_user_breaks($date,$user_id)
        {
            $break = DB::table('break')
            ->where('user_id', $user_id)
            // ->where('status', 1)
            ->where('date', $date)
            ->get();
            return $break;
        }
}

if (!function_exists('first_breakTime')) {
    
        function FirstBreakTime($date,$user_id)
        {
            $break = DB::table('break')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->where('date', $date)
            ->limit(1)
            ->orderBy('id', 'ASC')
            ->first();
            return $break;
        }
}

if (!function_exists('SecBreakTime')) {
    
        function SecBreakTime($date,$user_id)
        {
            $break = DB::table('break')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->where('date', $date)
            ->limit(1)
            ->orderBy('id', 'DESC')
            ->first();
            return $break;
        }
}

if (!function_exists('total_user_files')) {
    
        function total_user_files($user_id)
        {
            $total_user_files = DB::table("documents")
            ->where('user_id','=', $user_id)
            ->count();

            return $total_user_files;
        }
}



if (!function_exists('hoursToMinutes')) {
    
        function hoursToMinutes($hours)
        {
            $minutes = 0; 
            if (strpos($hours, ':') !== false) 
            { 
                list($hours, $minutes) = explode(':', $hours); 
            } 
            return $hours * 60 + $minutes; 
        }
}


if (!function_exists('minutesToHours')) {
    
        function minutesToHours($minutes)
        {
            $hours = (int)($minutes / 60); 
            $minutes -= $hours * 60; 
            return sprintf("%d:%02.0f", $hours, $minutes); 
        }
}


if (!function_exists('get_user_incentive_details')) {
    
        function get_user_incentive_details($user_id, $sell_amount)
        {
            $incentive_details = DB::table("incentive")
            ->where('user_id','=', $user_id)
            ->get();
            foreach ($incentive_details as $key) {
                if ($sell_amount >= $key->incentiveFrom && $sell_amount <= $key->incentiveTo) {
                    return $key->id;
                }
        }

        return 0;
}
}



