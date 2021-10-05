<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search(Request $request){
        if (trim($request->input('search')) != '') {
            $search = $this->parse_search($request->input('search'));
            $response = [];
            $founded = [];
            $objects = \App\Models\categories::all()->merge(\App\Models\products_detail::all());

            // в первом цикле ищем только по названиям услуги - название в приоритете
            foreach ($objects as $object){
                if (method_exists($object, 'trashed')) {
                    if ($object->trashed())
                        $object->trashed = true;
                    else
                        $object->trashed = false;
                }
                if(mb_strpos($object->name, $request->input('search')) === 0){
                    array_push($response, $object);
                }
                $string = $this->format_title($object);
                // ищем каждое отдельное слово из запроса
                foreach ($search as $s) {
                    if (strpos(mb_strtolower($string), mb_strtolower($s)) !== false) {
                        // делаем проверку, чтобы одна запись не попала в ответ больше одного раза
                        $push = true;
                        foreach ($founded as $key => $found){
                            if ($founded[$key]['object']->id == $object->id){
                                $founded[$key]['matches'] += 1;
                                $push = false;
                            }
                        }
                        if ($push){
                            array_push($founded, ['object'=>$object, 'matches'=>1]);
                        }
                    }
                }
            }

            // сортируем результаты по кол-ву совпадений
            $founded = SearchController::sort_by_matches_number($founded);
            foreach ($founded as $found){
                $ok = true;
                foreach ($response as $res) {
                    if($res->id == $found['object']->id){
                        $ok = false;
                    }
                }
                if($ok) {
                    array_push($response, $found['object']);
                }
            }
            $founded = [];

            // во втором цикле ищем по всем остальным полям
            foreach ($objects as $object){
                $string = $this->format_content($object);
                foreach ($search as $s) {
                    if (strpos(mb_strtolower($string), mb_strtolower($s)) !== false) {
                        $push = true;
                        foreach ($founded as $key => $found) {
                            if ($founded[$key]['object']->id == $object->id) {
                                $founded[$key]['matches'] += 1;
                                $push = false;
                            }
                        }
                        foreach ($response as $key => $found) {
                            if ($response[$key]->id == $object->id) {
                                $push = false;
                            }
                        }
                        if ($push) array_push($founded, ['object'=>$object,'matches'=>1]);
                    }
                }
            }

            // сортируем результаты по кол-ву совпадений
            $founded = SearchController::sort_by_matches_number($founded);
            foreach ($founded as $found){
                array_push($response, $found['object']);
            }
            return view('search', ['search' => $request->input('search'), 'results' => $response]);
        } else {
            return redirect()->route('main-page');
        }
    }

    // знаки препинания для удаления
    public static $signs = [
        '-', '—', ',', '.', '!',
        '?', ':', ';', '(', ')',
        '[', ']', '{', '}', '<',
        '>', '"', '«', '»', '\'',
    ];

    public static function parse_search($search){
        // удаляем повторящиеся знаки
        $temp = preg_split('//u', $search);
        $search = [];
        foreach($temp as $key => $char){
            if ($key > 0 && $temp[$key - 1] != $char){
                array_push($search, $char);
            }
        }
        $search = implode($search);
        // в запросе заменяем знаки препинания на пробелы
        $search = str_replace(SearchController::$signs, ' ', $search);
        // удаляем лишние пробелы
        while (strpos($search, '  '))
            $search = str_replace('  ', ' ', $search);
        // делим запрос на отдельные слова
        return explode(' ', trim($search));
    }

    private function format_title($object){
        $string = strip_tags($object->name);
        $string = str_replace(SearchController::$signs, ' ', $string);
        return SearchController::format_string($string);
    }

    private function format_content($object){
        $string = '';
        if ($object instanceof \App\Models\categories) {
            $string = str_replace(SearchController::$signs, ' ', strip_tags($object->description));
            $object->description = mb_substr(strip_tags($object->description), 0, 250).'...';
        } else
        if ($object instanceof \App\Models\products_detail) {
            // объединяем все поля в одно, очищаем от лишних знаков
            $string = str_replace(SearchController::$signs, ' ', strip_tags($object->description));
            $string = $string.' '.str_replace(SearchController::$signs, ' ', strip_tags($object->description_short));
            $string = $string.' '.str_replace(SearchController::$signs, ' ', strip_tags($object->vendor_code));
            $string = $string.' '.str_replace(SearchController::$signs, ' ', strip_tags($object->brand()->first()->name));
            $string = $string.' '.str_replace(SearchController::$signs, ' ', strip_tags($object->model));
            $object->description = mb_substr(strip_tags($object->description), 0, 250).'...';
        }
        return SearchController::format_string($string);
    }

    public static function format_string($string){
        $string = str_replace('́', '', $string);
        $temp = preg_split('//u', $string);
        $string = [];
        foreach($temp as $key => $char){
            if ($key > 0 && $temp[$key - 1] != $char){
                array_push($string, $char);
            }
        }
        $string = implode($string);
        return $string;
    }

    public static function sort_by_matches_number($founded){
        if (count($founded) > 0) {
            for($i1 = 0; $i1 < count($founded); $i1++) {
                $f_max = 0;
                for($i2 = $i1; $i2 < count($founded); $i2++) {
                    if ($founded[$i2]['matches'] >= $founded[$f_max]['matches']) {
                        $f_max = $i2;
                    }
                }
                $temp = $founded[$i1];
                $founded[$i1] = $founded[$f_max];
                $founded[$f_max] = $temp;
            }
        }
        return $founded;
    }
}
