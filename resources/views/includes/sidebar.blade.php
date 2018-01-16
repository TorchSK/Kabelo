<div class="ui right sidebar inverted vertical menu">
    <a class="header right aligned item" id="close_sidebar_btn"><i class="chevron left icon"></i>Close</a>

    @if (Auth::check())
      <div id="main_search_form_item">

        {!! Form::open(["autocomplete" => "off","class" => "main_search_form"]) !!}
          <div class="ui left icon fluid input">
            {!! Form::text("main_search", Request::get("email"), [
              "placeholder" => "Search users, dogs and breeders",
              "class" => "main_search"
            ]) !!}
            <i class="search teal icon"></i>
          </div>
        {!! Form::close() !!}
      </div>
    @endif

      @if (Auth::check())

      @if(isset($isOwnAsset) && $isOwnAsset && $editmode==0) 
      @if (Request::segment(3)=='litter')
      <div class="item">
        <a href="{!!Request::url()!!}/edit" class="ui orange button">
          {!!Lang::get('header.edit_litter')!!}
        </a>
      </div>
      @else
        <div class="item">
          <a href="{!!Request::url()!!}/edit" class="ui tiny fluid orange button">
            {!!Lang::get('header.edit_asset', ['segment'=> Request::segment(1)]) !!}
          </a>
        </div>
      @endif
    @endif
    
    <a href="{!!route('dog.index')!!}" class="header item"> Dogs</a>
    <a href="{!!route('kennel.index')!!}" class="header item">Kennels</a>
    <a href="{!!route('litter.index')!!}" class="header item">Puppies</a>

   <div class="header item">
      <i class="add square green icon"></i>Add
      <div class="menu">
          <a class="item" href="{!!route('dog.create')!!}">Add Dog</a>
          <a class="item" href="{!!route('kennel.create')!!}">Add kennel</a>
        </div>
    </div>

        <a href="{!!route('message.index')!!}" class="header item"><i class="mail blue icon"></i>Messages</a>

    <div class="header item">
      <div class="menu">
          <a class="item" href="{!!route('user.show',Auth::user()->id)!!}"><i class="user inverted icon"></i> Profile</a>
          <a class="item" href="{!!route('manage.photos')!!}"><i class="image inverted icon"></i> Manage Photos</a>
          <a class="item" href="{!!route('user.settings')!!}"><i class="settings inverted icon"></i> Settings</a>
          @if (Auth::user()->admin == 1)
          <a class="item" href="{!!route('admin.index')!!}"><i class="doctor inverted icon"></i> Admin</a>
          @endif
          <div class="ui divider"></div>
          <a href="/logout" class="item"><i class="power red icon"></i> Logout</a>
        </div>
      </div>
      @else

      <a class="item" href="/login">Login</a> 
      <a class="item" href="/register">Register</a>

      @endif
    </div>