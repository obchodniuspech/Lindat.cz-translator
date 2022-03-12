<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
<head>
<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,300,700" rel="stylesheet">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Překladač</title>

<meta name="viewport" content="initial-scale=1, width=device-width" />


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<link rel="stylesheet" href="./autocomplete/dist/tribute.css" />
<script src="./autocomplete/dist/tribute.js"></script>

<script src="./js/main.js?v=1.0001a"></script>
<link href="./css/app.css?v=1.0002ab" rel="stylesheet">

</head>
<body>




    @include('navigation')




    <div class="container">


        @if (Route::has('login'))
                @auth
                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     <strong>Tip:</strong> Využijte oblíbené položky (uložte hvězdičkou a vyvolejte pomocí :).
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
                @else
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                         <strong>Tip:</strong> Zaregistrujte se a využijte všechny funkce překladače.
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                @endauth
        @endif




        <div class="row mt-5">
        <input type="hidden" id="translationSaveFromText">
        <input type="hidden" id="storing" value="@isset ($storeMyData) @if ($storeMyData=='1') 1 @endif @else 0 @endisset">

            <div class="input-group">
              <select class="form-select" id="langFrom" aria-label="Example select with button addon">
                    <option value="uk" selected>Ukrajinština</option>
                    <option value="cs" >Čeština</option>
              </select>
              <button id="translateSwitchSides" class="btn btn-outline-secondary" type="button"><i class="bi bi-arrow-left-right"></i></button>
              <select id="langTo" class="form-select" aria-label="Example select with button addon">
                  <option value="cs" selected>Čeština</option>
                  <option value="uk" >Ukrajinština</option>
                </select>
            </div>


            <!--<div class="col-lg-6 col-5">
                <select class="form-control">
                    <option>Ukrajinština
                </select>
            </div>
            <div class="col-2">
                <button class="btn btn-secondary"><i class="bi bi-arrow-left-right"></i></button>
            </div>
            <div class="col-lg-6 col-5">
                <select class="form-control">
                    <option>Čeština
                </select>
            </div>-->
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 mt-4">
                <!--<div class="form-group">
                    <label for="exampleFormControlTextarea1">Text</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>-->

                <div class="input-group">
                    <textarea class="form-control textFrom" id="textFrom" rows="3">Привіт. Як вас звати?</textarea>
                    <span class="input-group-addon btn btn-primary align-middle" id="translateButton"><i class="bi bi-arrow-right-circle-fill"></i></span>
                </div>

            </div>
            <div class="card col-12 col-lg-6 mt-4">
                <div class="card-body"  id="translation">Překlad</div>
                <div class="card-footer pt-3 pb-3 align-items-end text-end">

                <div class="row">
                    <div class="col-lg-10 col-12 form-check">
                        @if (Route::has('login'))
                                @auth
                                   <input class="form-check-input" type="checkbox" value="" @isset ($storeMyData) @if ($storeMyData=='1') checked="checked" @endif @endisset id="idoagree">
                                     <label class="form-check-label" for="flexCheckDefault">
                                       I do agree with storing my data for the purpose of improving the translator.
                                     </label>
                                @else

                                @endauth
                        @endif

                    </div>

                    <div class="col-lg-2 col-12">
                        @if (Route::has('login'))
                                @auth
                                   <i id="translateStar" class="bi bi-star" style="font-size: 30px;"></i>
                                @else
                                @endauth
                        @endif
                        <i id="translateCopy" class="bi bi-clipboard" onclick="copyToClipboard('#translation');" style="font-size: 30px;"></i>
                    </div>

                </div>
                </div>
            </div>
        </div>

    </div>



<script>
//https://github.com/zurb/tribute#loading-remote-data

var users = [
  @foreach ($favourites AS $fav)
  { name: '{{$fav->textFrom}}'},
  @endforeach
];

var tributeInstance = new Tribute({
  trigger: ':',

  selectTemplate: function (item) {
    // return '<span class="tweet__handle" contenteditable="false">@' + item.original.username + '</span>';
    return '' + item.original.name;
  },

  menuItemTemplate: function (item) {
    return `
      <span class="handle__name">${item.original.name}</span>
      <!--<span class="handle__username">@${item.original.username}</span>-->
    </div>`
  },

  lookup: function (user) {
    return user.name + user.username;
  },

  values: users
});

tributeInstance.attach(document.querySelector('#textFrom'));



  </script>




</body>
</html>
