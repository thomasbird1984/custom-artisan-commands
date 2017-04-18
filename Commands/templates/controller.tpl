<?php namespace App\Http\Controllers;

use Config;
use Session;
use Validator;
use Illuminate\Http\Request;

use App\Models\{{nameUpper}};

class {{nameUpper}}Controller extends Controller {

    public function edit(Request $request, $id) {
        ${{nameLower}} = {{nameUpper}}::find($id);
        $input = $request->except('_token');

        foreach($input as $key => $item) {
            ${{nameLower}}->$key = $item;
        }

        ${{nameLower}}->save();
        return back();
    }

    public function view() {
        ${{namePlural}} = {{nameUpper}}::orderBy('created_at', 'desc')->paginate(Config('global.paginate'));
        return view('{{namePlural}}.view', ['{{namePlural}}' => ${{namePlural}}]);
    }

    public function single($id) {
        ${{nameLower}} = {{nameUpper}}::find($id);
        return view('{{namePlural}}.single', ['{{nameLower}}' => ${{nameLower}}]);
    }

    public function remove(Request $request, $id) {
        ${{nameLower}} = {{nameUpper}}::find($id);
        ${{nameLower}}->delete();

        return back();
    }

    public function create(Request $request) {
        $input = $request->except('_token');

        $validator = Validator::make($request->all(), [
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            ${{nameLower}} = {{nameUpper}}::create($input);

            if(${{nameLower}}) {

            } else {

            }

            return back();
        }
    }
}