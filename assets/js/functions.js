userInfo()

fetchKulay()

function formatDate(date_val){

    var formattedDate = new Date(date_val);
    var d = formattedDate.getDate();
    var m = formattedDate.getMonth();
    // m += 1;  // JavaScript months are 0-11
    var y = formattedDate.getFullYear();

    const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
    ];

    if(d < 10){

        d = "0" + d
    }

    m = monthNames[m]

    return m +" "+ d + ", " +y
}



function empDD(id){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            action:"emp_dd"
        },
        dataType: "JSON",
        success: function (response) {
            
            $('#'+id).html(response)
        }
    })
}



function userInfo(){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            action:"user_info"
        },
        dataType: "JSON",
        success: function (response) {

            var fullname = response.Fname +" "+ response.Lname
            
            $('#usr_name').html(fullname)
            $('#usr_email').html(response.Usrname)
        }
    })
}



function bgKulay(color_id){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            colorid:color_id,
            action:"change_bg"
        },
        dataType: "JSON",
        success: function (response) {
            
            console.log('color changed')
        }
    })
}



function fetchKulay(){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            action:"get_bg_cookie"
        },
        dataType: "JSON",
        success: function (response) {
            
            $('.bg-theme').attr('class', 'bg-theme bg-'+response)

            // alert(response)
        }
    })
}



function catDD(id){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            action:"cat_dd"
        },
        dataType: "JSON",
        success: function (response) {
            
            $('#'+id).html(response)
        }
    })
}



function itemsDD(id){

    $.ajax({
        type: "POST",
        url: "exec/fetch.php",
        data: {
            action:"item_dd"
        },
        dataType: "JSON",
        success: function (response) {
            
            $('#'+id).html(response)
        }
    })
}