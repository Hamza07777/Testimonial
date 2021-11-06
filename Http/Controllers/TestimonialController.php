<?php

namespace Modules\Testimonial\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Testimonial\Entities\Testimonial;

class TestimonialController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (view()->exists('testimonial.list'))

        {
            $testimonial=Testimonial::all();
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Page is Loading .......');
            return view('testimonial.list')->with('testimonial',$testimonial);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (view()->exists('testimonial.new'))

        {

            return view('testimonial.new');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file' => 'required|mimes:jpeg,png,jpg',
       ]);

       if ($request->hasFile('file')) {
        $extension=$request->file->extension();
        $filename=time()."_.".$extension;
        $request->file->move(public_path('testimonial'), $filename);
    }
        $testimonial=Testimonial::create([
            'name' => $request['name'],
            'designation' => $request['designation'],
            'description' => $request['description'],
            'file' => $filename,
        ]);

            if($testimonial)
            {
                session()->flash('alert-type', 'success');
                session()->flash('message', 'Testimonial added successfully');
                return redirect()->route('testimonial.index');
            }
            else{
                session()->flash('alert-type', 'error');
                session()->flash('message', 'Record Not Added.');
                return redirect()->back();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (view()->exists('testimonial.new'))

        {

            $testimonial=Testimonial::findOrFail($id);
            session()->flash('alert-type', 'success');
            session()->flash('message', 'Page is Loading .......');
            return view('testimonial.new')->with('testimonial',$testimonial);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $testimonial=Testimonial::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file' => 'mimes:jpeg,png,jpg',
       ]);
  
       if ($request->hasFile('file')) {

           if (isset($testimonial->file) && file_exists(public_path('testimonial/'.$testimonial->file))) {
               unlink(public_path('testimonial/'.$testimonial->file));
           }
           $extension=$request->file->extension();
           $filename=time()."_.".$extension;
           $request->file->move(public_path('testimonial'), $filename);
       }
       else{
        $filename=$testimonial->file;
       }
        $testimonial=Testimonial::whereId($id)->update([
            'name' => $request['name'],
            'designation' => $request['designation'],
            'description' => $request['description'],
            'file' => $filename,
            ]);

          if($testimonial)
            {
                session()->flash('alert-type', 'success');
                session()->flash('message', 'Testimonial Updated Successfully.');
                return redirect()->route('testimonial.index');
            }
            else{
                session()->flash('alert-type', 'error');
                session()->flash('message', 'Record Not Updated.');
                return redirect()->back();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if (isset($testimonial->file) && file_exists(public_path('testimonial/'.$testimonial->file))) {
            unlink(public_path('testimonial/'.$testimonial->file));
        }
        $testimonial->delete();

        session()->flash('alert-type', 'success');
        session()->flash('message', 'Testimonial deleted successfully');

        return redirect()->route('testimonial.index');
    }

    public function multiplecourse_quizdelete(Request $request)
	{
		$id = $request->id;
		foreach ($id as $user)
		{
            $testimonial = Testimonial::findOrFail($user);
                if (isset($testimonial->file) && file_exists(public_path('testimonial/'.$testimonial->file))) {
                    unlink(public_path('testimonial/'.$testimonial->file));
                }
            $testimonial->delete();
		}
        session()->flash('alert-type', 'success');
        session()->flash('message', 'Testimonials deleted successfully');

        return redirect()->route('testimonial.index');
	}


    // /**
    //  * Display a listing of the resource.
    //  * @return Renderable
    //  */
    // public function index()
    // {
    //     return view('testimonial::index');
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    // public function create()
    // {
    //     return view('testimonial::create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('testimonial::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function edit($id)
    // {
    //     return view('testimonial::edit');
    // }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
