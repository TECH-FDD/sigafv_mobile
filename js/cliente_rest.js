$(function(){


$.ajax({
  type: 'GET',
  url: 'http://rest.learncode.academy/api/johnbob/friends',
  success: function(data) {
    console.log("I have friends!", data); //returns all of johnbob's friends
  }
});

}

