<?php
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Models\Task;
use \App\Http\Requests\TaskRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function(){

    return redirect->route('/tasks.index'); 
});

Route::get('/tasks', function () {

      return view('/index', [
        'tasks'=> \App\Models\Task::latest()->paginate(7)]
    );
})->name('tasks.index');


Route::view('/tasks/create', 'create')->name('tasks.create');


Route::get('/tasks/{task}/edit', function(Task $task) {

    return view('/edit', [
        'task' => $task]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function(Task $task) {

    return view('/show', ['task' => $task]);
})->name('tasks.show');


Route::post('/tasks', function(TaskRequest $request){
   

    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task Created Sucessfully!');

})->name('tasks.store');

Route::put('/tasks/{task}', function(Task $task ,TaskRequest  $request){
  
   // $data = $request->validated();
   // $task->title = $data['title'];
   // $task->description = $data['description'];
   // $task->long_description = $data['long_description'];

   //  $task->save();
   $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task Updated Sucessfully!');

})->name('tasks.update');

Route::delete('/tasks/{task}', function(Task $task){
      $task->delete();
      return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully.!');
})->name('tasks.destroy');


Route::put('tasks/{task}/toggle-complete', function(Task $task){
    
    $task->toggleComplete();

   return redirect()->back()->with('success', 'Task updated Successfully..!');
})->name('tasks.toggle-complete');

Route::fallback(function($name){

    return 'No Route Found';
});


