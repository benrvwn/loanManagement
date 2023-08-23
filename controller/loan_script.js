
function reset(){
    $('tbody').empty();
    $("span:eq(0)").html("");
    $("span:eq(1)").html("");
    $("span:eq(2)").html("");
    $("span:eq(3)").html("");
    $("span:eq(4)").html("");
    $("span:eq(5)").html("");
    $("input").val("");
}

$(document).ready(function(){
    $('#kanor').submit(function(event){
        event.preventDefault();
        
        $('tbody').empty();
        $('#cancel').removeAttr("disabled");
        const formData = $(this).serialize();
        $.post("loan-process.php", formData, function(response){
            console.log(response);
            $("span:eq(0)").html(response.payment);
            $("span:eq(1)").html(response.numPayment);
            $("span:eq(2)").html(response.actualNoPayment);
            $("span:eq(3)").html(response.totalEarlyPayment);
            $("span:eq(4)").html(response.totalInterest);
            $("span:eq(5)").html(response.lenderName);

            $.ajax({
                url: 'loan-process.php',
                method: 'GET',
                success: function(response){
                    $("tbody").append(response);
                },
                error: function(error){
                    console.log("doesnt work lmao", error)
                }
            })

        }, "json")
    })
    $("#refresh").click(function(event){
        event.preventDefault();
        $('#cancel').attr("disabled", "true");
        reset();
        // event.preventDefault();
        // $('tbody').empty();
        // $("span:eq(0)").html("");
        // $("span:eq(1)").html("");
        // $("span:eq(2)").html("");
        // $("span:eq(3)").html("");
        // $("span:eq(4)").html("");
        // $("span:eq(5)").html("");
        // $("input").val("");
    })
    $("#cancel").click(function(event){
        event.preventDefault();
        reset();
        $.ajax({
            url: 'loan-process.php',
            method: 'DELETE',
            success: function(response){
                console.log(response);
            },
            error: function(error){
                console.log("gagi di gumana haha", error);
            }
        })
        
    })
})