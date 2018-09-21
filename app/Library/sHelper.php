<?php
namespace App\Library;


use App\Models\City;
use App\Models\Country;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\GrupComment;
use App\Models\GrupPost;
use App\Models\GrupLike;
use App\Models\User;
use App\Models\User_grup;
use App\Models\UserFollowing;
use App\Models\UserLocation;
use App\Models\NotifGrup;
use App\Models\Event;
use App\Models\EventComment;
use Auth;

class sHelper
{

    static $notifications = null;


    public static function countevent()
    {
        $data =  Event::join('users', 'users.id', '=', 'events.id_users')->where('akhir','>', date('Y-m-d H:i:s'))->count();
        return $data;
    }
    public static function followButton($following, $follower, $element, $size = ''){

        if ($following  == $follower) return "This is me";

        $relation = UserFollowing::where('following_user_id', $following)->where('follower_user_id', $follower)->get()->first();

        if ($relation){
            if ($relation->allow == 0) {
                return '<a href="javascript:;" class="btn btn-default request-button '.$size.'" onclick="follow(' . $following . ', ' . $follower . ', \''.$element.'\', \''.$size.'\')"></a>';
            }elseif ($relation->allow == 1){
                return '<a href="javascript:;" class="btn btn-default following-button '.$size.'" onclick="follow('.$following.', '.$follower.', \''.$element.'\', \''.$size.'\')"></a>';
            }
        }

        return '<a href="javascript:;" class="btn btn-default follow-button '.$size.'" onclick="follow('.$following.', '.$follower.', \''.$element.'\', \''.$size.'\')"><i class="fa fa-plus"></i> Follow</a>';

    }

    public static function grupButton($id_grup, $id_user, $element, $size = ''){

        $relation = User_grup::where('id_user',$id_user)->where('id_groups',$id_grup)->get()->first();

        if ($relation){
            if ($relation->allow == 0) {
                return '<a href="javascript:;" class="btn btn-default request-button '.$size.'" onclick="gabung(' . $id_grup . ', ' . $id_user . ', \''.$element.'\', \''.$size.'\')"></a>';
            }elseif ($relation->allow == 1){
                return '<a href="javascript:;" class="btn btn-default invite-button '.$size.'" onclick="gabung('.$id_grup.', '.$id_user.', \''.$element.'\', \''.$size.'\')"></a>';
            }
        }

        return '<a href="javascript:;" class="btn btn-default gabung-button '.$size.'" onclick="gabung('.$id_grup.', '.$id_user.', \''.$element.'\', \''.$size.'\')"><i class="fa fa-plus"></i> Gabung</a>';

    }

    public static function deniedButton($me, $follower, $element, $size = ''){
        if ($me  == $follower) return "";

        $relation = UserFollowing::where('following_user_id', $me)->where('follower_user_id', $follower)->get()->first();

        if ($relation){
            if ($relation->allow == 1) {
                return '<a href="javascript:;" class="btn btn-danger '.$size.'" onclick="deniedFollow('.$me.', '.$follower.', \''.$element.'\', \''.$size.'\')" data-toggle="tooltip" title="Block">
                <i class="fa fa-times"></i>
                </a>';
            }
        }
    }


    public static function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $km = $miles * 1.609344;

        if ($km < 1){
            return round($miles * 1609.344).' Meter';
        }

        return round($km, 2).' Km';

    }

    public static function notifications($idgrup=null){
        if (self::$notifications == null){
            $notifications = [];

            $user = Auth::user();

            $followers = $user->follower()->where('allow', 0)->count();
            if ($followers > 0){
                $notifications[] = [
                    'url' => url('/followers/pending'),
                    'icon' => 'fa-user-plus',
                    'text' => $followers.' follower requests'
                ];
            }

            $relatives = $user->relatives()->where('allow', 0)->count();
            if ($relatives > 0){
                $notifications[] = [
                    'url' => url('/relatives/pending'),
                    'icon' => 'fa-user-circle-o',
                    'text' => $relatives.' relatives requests'
                ];
            }

            $comments = PostComment::where('seen', 0)->with('user')->join('posts', 'posts.id', '=', 'post_comments.post_id')->join('users','users.id','=','post_comments.comment_user_id')
            ->where('posts.user_id', $user->id)->where('comment_user_id', '!=', $user->id)->orderBy('post_comments.id', 'DESC');
            if ($comments->count() > 0){
                foreach ($comments->get() as $comment){
                    $notifications[] = [
                        'url' => url('/post/'.$comment->post_id),
                        'icon' => 'fa-commenting',
                        'text' => $comment->name.' left a comment on your post.'
                    ];
                }

            }

            $likes = PostLike::where('seen', 0)->with('user')->join('posts', 'posts.id', '=', 'post_likes.post_id')->join('users','users.id','=','post_likes.like_user_id')
            ->where('posts.user_id', $user->id)->where('like_user_id', '!=', $user->id)->orderBy('post_likes.id', 'DESC');
            if ($likes->count() > 0){
                foreach ($likes->get() as $likne){
                    $notifications[] = [
                        'url' => url('/post/'.$likne->post_id),
                        'icon' => 'fa-heart',
                        'text' => $likne->name.' liked your post.'
                    ];
                }

            }

            $User_grup = User_grup::where('id_user',$user->id);
            foreach ($User_grup->get() as $key) {
                $postgrup = GrupPost::where('posts_grup.group_post_id','=',$key->id_groups)->join('user_groups','user_groups.id_groups','=','posts_grup.group_post_id')->join('grup','grup.id_grup','=','posts_grup.group_post_id')->where('posts_grup.user_id','!=',$user->id)->where('user_groups.id_groups','=',$key->id_groups)->where('user_groups.id_user','!=',$user->id)->orderBy('posts_grup.id_post_grup', 'DESC');
                if ($postgrup->count() > 0){
                    foreach ($postgrup->get() as $postsgrup){
                        $ceknama = User::where('id',$postsgrup->user_id)->get()->first();
                        $cekpost = NotifGrup::where('seen',1)->join('posts_grup','posts_grup.id_post_grup','=','notif_grup.id_post')->where('posts_grup.user_id','!=',$user->id)->where('notif_grup.id_post',$postsgrup->id_post_grup)->where('notif_grup.id_user',$user->id);
                        if ($cekpost->count() < 1) {
                            $notifications[] = [
                                'url' => url('group/diskusi/postgrup/'.$postsgrup->id_post_grup),
                                'icon' => 'fa-users',
                                'nama' => $ceknama->name,
                                'text' => 'mengirimkan sesuatu di',
                                'grup' => $postsgrup->nama_grup
                            ];
                        }
                    }
                }
            }
            $commentsgrup = GrupComment::where('seen', 0)->with('user')->join('posts_grup', 'posts_grup.id_post_grup', '=', 'grup_post_comments.grup_post_id')->join('users','users.id','=','grup_post_comments.comment_grup_user_id')
            ->where('posts_grup.user_id', $user->id)->where('comment_grup_user_id', '!=', $user->id)->orderBy('grup_post_comments.id', 'DESC');
            if ($commentsgrup->count() > 0){
                foreach ($commentsgrup->get() as $commentgrup){
                    $notifications[] = [
                        'url' => url('/postgrup/'.$commentgrup->grup_post_id),
                        'icon' => 'fa-commenting',
                        'text' => $commentgrup->name.' left a comment on your post in grup.'
                    ];
                }

            }

            $likesgrup = GrupLike::where('seen', 0)->with('user')->join('posts_grup', 'posts_grup.id_post_grup', '=', 'post_grup_likes.grup_post_id')->join('users','users.id','=','post_grup_likes.like_user')
            ->where('posts_grup.user_id', $user->id)->where('like_user', '!=', $user->id)->orderBy('post_grup_likes.grup_post_id', 'DESC');
            if ($likesgrup->count() > 0){
                foreach ($likesgrup->get() as $likegrup){
                    $notifications[] = [
                        'url' => url('/postgrup/'.$likegrup->grup_post_id),
                        'icon' => 'fa-heart',
                        'text' => $likegrup->name.' liked your post in grup.'
                    ];
                }

            }
            // if (Auth::user()->role == 'admin') {
            $commentsnotif = EventComment::where('seen', 0)->with('user')->join('events', 'events.id_events', '=', 'event_coment.id_events')->join('users','users.id','=','event_coment.id_users')->where('event_coment.id_users', '!=', $user->id)->orderBy('event_coment.id', 'DESC');
            if ($commentsnotif->count() > 0){
                foreach ($commentsnotif->get() as $commentnotif){
                    $notifications[] = [
                        'url' => url('/events/'.$commentnotif->id_events),
                        'icon' => 'fa-commenting',
                        'text' => $commentnotif->name.' Meninggalkan Komentar di Event.'
                    ];
                }
            }
            // }
            self::$notifications = $notifications;

        }

        return self::$notifications;
    }

    public static function ip($request){
        $ip = $request->headers->get('CF_CONNECTING_IP');
        if (empty($ip))$ip = $request->ip();
        return $ip;
    }

    public static function alternativeAddress($ip, $id){
        $query = IPAPI::query($ip);

        if ($query->status == "success") {



            $country_name = $query->country;
            $lat = $query->lat;
            $lon = $query->lon;
            $city = $query->city;
            $country_code = $query->countryCode;

            $find_country = Country::where('shortname', $country_code)->first();
            $country_id = 0;
            if ($find_country) {
                $country_id = $find_country->id;
            } else {
                $country = new Country();
                $country->name = $country_name;
                $country->shortname = $country_code;
                if ($country->save()) {
                    $country_id = $country->id;
                }
            }

            $city_id = 0;
            if ($country_id > 0) {
                $find_city = City::where('name', $city)->where('country_id', $country_id)->first();
                if ($find_city) {
                    $city_id = $find_city->id;
                } else {
                    $city = new City();
                    $city->name = $city;
                    $city->zip = "1";
                    $city->country_id = $country_id;
                    if ($city->save()) {
                        $city_id = $city->id;
                    }
                }
            }


            if (!empty($lat) && !empty($lon) && !empty($city) && !empty($country_code) && !empty($city_id) && !empty($country_id)) {

                self::updateLocation($id, $city_id, $lat, $lon, $city);
            }
        }

    }

    public static function updateLocation($id, $city_id, $lat, $long, $address){
        $find_location = UserLocation::where('user_id', $id)->first();


        if (!$find_location) {

            $find_location = new UserLocation();
            $find_location->user_id = $id;

        }


        $find_location->city_id = $city_id;
        $find_location->latitud = $lat;
        $find_location->longitud = $long;
        $find_location->address = $address;

        $find_location->save();
    }
}