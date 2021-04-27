<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class Posts extends Component
{

    public $posts;
    public $postid, $title, $description;
    public $isopen = 0;

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }

    public function showModal()
    {
        $this->isopen = true;
    }

    public function hideModal()
    {
        $this->isopen = false;
    }

    public function store()
    {
        $this->validate(
            [
                'title' => 'required',
                'description' => 'required',
            ]
        );

        post::updateOrCreate(['id' => $this->postid], [

            'title' => $this->title,
            'description' => $this->description
        ]);


        $this->hideModal();

        session()->flash('info', $this->postid ? 'Post Update Successfully' : 'Post Update Successfuly');

        $this->postid = '';
        $this->title = '';
        $this->description = '';
    }


    public function edit($id)
    {

        $post = post::findOrFail($id);
        $this->postid = $id;
        $this->title = $post->title;
        $this->description = $post->description;

        $this->showModal();
    }


    public function delete($id)
    {

        post::find($id)->delete();
    }
}
