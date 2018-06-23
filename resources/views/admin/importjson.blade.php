@extends('layouts.admin')
@section('content')

<div class="pad admin_wrapper ct">

	<div class="admin_right ct">
    <div class="ui fluid form">
      <div class="field" id="import_json">
        <label>JSON</label>
        <textarea></textarea>
      </div>
    </div>

    <div class="ui green button" id="import_json_btn">Nahraj</div>


<table class="ui compact celled definition table" id="import_json_table">
  <thead>
    <tr>
      <th></th>
      <th>Image</th>
      <th>ExtID</th>
      <th>Name</th>
      <th>Desc</th>
      <th>Category</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="collapsing">
        <div class="ui fitted checkbox">
          <input type="checkbox"> <label></label>
        </div>
      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>

        <select class="ui dropdown">
          @foreach(App\Category::all() as $category)
          <option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
        </select>

      </td>
      <td><div class="ui input"><input type="text" value="1" /></div></td>
    </tr>
  
  </tbody>
  <tfoot class="full-width">
    <tr>
      <th></th>
      <th colspan="6">
        <div class="ui right floated small primary labeled icon button">
          <i class="user icon"></i> Pridaj produkt
        </div>
        <div class="ui small green button" id="import_json_accept">
          Nahraj!
        </div>

      </th>
    </tr>
  </tfoot>
</table>


  </div>
</div>


@stop