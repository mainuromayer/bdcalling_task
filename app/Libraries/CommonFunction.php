<?php

namespace App\Libraries;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CommonFunction {

    /*************************************
     * Starting ISP JOURNAL Common functions
     *************************************/

    /**
     * @param Carbon|string $updated_at
     * @param string $updated_byg
     * @return string
     * @internal param $Users->id /string $updated_by
     */

    public static function formatLastUpdatedTime( $database_timestamp_str ): string {
        $database_timestamp = strtotime( $database_timestamp_str );
        if ( !$database_timestamp ) {
            return false;
        }
        return date( "F d, Y \a\\t h:i A", $database_timestamp );
    }

    public static function getUserId() {

        if ( Auth::user() ) {
            return Auth::user()->id;
        } else {
            return 0;
        }
    }

}
