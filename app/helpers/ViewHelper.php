<?php
class ViewHelper {
    public function getCountries($view) {
        $countries = Country::all();
        if (count($countries) > 0) {
            $options = array_combine($countries->lists('code'), $countries->lists('name'));
        } else {
            $options = array(null, 'No Countries');
        }
        $view->with('countries', $options);
    }

    public function getCommunicationTypes($view) {
        $types = CommunicationType::all();
        if (count($types) > 0) {
            $options = array_combine($types->lists('code'), $types->lists('name'));
        } else {
            $options = array(null, 'No Communication Types');
        }
        $view->with('communication_types', $options);
    }

    public static function avatar($image) {
        return asset("uploads/avatars/$image");
    }

    public static function country($code) {
        $country = Country::where('code', '=', $code)->get()->first();

        return $country ? $country->name : 'Bolivia';
    }
}
