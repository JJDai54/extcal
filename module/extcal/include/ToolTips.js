if (typeof MooTools !== 'undefined') {
    window.addEvent('domready', function () {
        var extcalTips = new Tips('.extcalTips');
    });
}


function show_fieldset(objParent, idParent, idToShow){
//alert ("bascule_fieldset");
//var titi = this.attributes["name"].value;
//alert ("bascule_fieldset => self = " + objParent.value);
//alert ("bascule_fieldset => reccurence = " + titi.attributes["reccurence"].value);
//alert ("bascule_fieldset => value = " + titi.attributes["value"].value);

//alert ("idParent => value = " + idParent);
  objTypeRecur = document.getElementById("type_reccurence");
//alert ("objTypeRecur => name = " + objTypeRecur.name);


  var allObjs = objTypeRecur.getElementsByTagName("fieldset");
  var fsEtat = 'hidden'; // visible -
//  alert("nb obj = " + allObjs.length);

  for (var i = 0; i < allObjs.length; i++) {
//     alert("objFs = " + allObjs[i].id);
     allObjs[i].style.visibility = fsEtat;
     allObjs[i].style.display = 'none';

  }

  
  objToShow = document.getElementById(idToShow);
  objToShow.style.visibility = 'visible';
  objToShow.style.display = 'block';

//alert ("bascule_fieldset => parent [" + idParent + "]= " + objParent.name + " | enfant [" + idToShow + "]= " + objToShow.name);
}

//alert ("zzzzzzzzzzzz");
