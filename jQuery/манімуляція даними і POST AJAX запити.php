<script>

            
    // Відправляю дані:
    $.ajax({
        type: 'post',
        url: '{{URL::to('/')}}/hr',
        data: $('#changePoint').serialize(),
        //data: $('#changePoint').serialize() + '&action=test_ajax',
    })
    .done (function (data) {
        // console.log('form was submitted');
    })
    .fail (function () {
        // console.log('form error');
    });

    // Зміна атрибута:
    $('#identifier').attr("src",new_value);
    

/////////////////////////////////////////////////////////



    $(function () {

        // Ця функція не працює для нових, динамічно створюваних обєктів:
        //$(".memberPoint").bind("click", function() {
        
        // Значення атрибута при кліку на нього:
        $('body').on('click', '.memberPoint', function(){

            // Якщо вже десь є пульсація, то видаляю клас:
            if($(".pulsation").length == 1) {
                $(".pulsation").removeClass("pulsation");
            }
            
            // Додаю пульсацію до поточного обєкта:
            $(this).addClass("pulsation");
            
            // Беру id:
            $("#memberIdToChange").val($(this).attr("id").substring(6));
            
            // Беру ім'я:
            var member = $(this).attr("id");
            var memberName = $("#span_" + member).text();
            $('#dialog').prop('title', $.trim(memberName)); // при першому завантаженні вікна
            $('.ui-dialog-title').text($.trim(memberName)); // при подальших завантаженнях
            
            // Беру параметри:
            $("#distance").val($(this).attr("distance"));
            $("#rank").val($(this).attr("rank"));

            // Показую діалог:
            $( "#dialog" ).dialog({
                width: 220,
                position: {my: "left top", at: "left top"},
                close: function() {
                    // При закриванні вікна виключаю пульсацію:
                    $(".pulsation").removeClass("pulsation");
                }
            });

            // Забороняю перехід по ссилці:
            return false;
            
        });
    
    });

///**************************************************/

	// Форма для оновлення відстані і рангу:
	$(function () {
        
        // Зміна координат цятки:
		$('#changePoint').on('submit', function (e) {
		
			// Блокую перехід на сторінку:
			e.preventDefault();

            // Відправляю дані:
			$.ajax({
				type: 'post',
				url: '{{URL::to('/')}}/hr',
				data: $('#changePoint').serialize(),
			})
			.done (function () {
				// console.log('form was submitted');
			})
			.fail (function () {
				// console.log('form error');
			});
			
			// Оновляю координати цятки на карті:
			var ratio = {{$ratio}};
			var pointSize = [];
				pointSize['width'] = ratio * 10;
				pointSize['height'] = ratio * 10;

			var newCoordinates = [];
				newCoordinates['x'] = Math.ceil($('#distance').val() * ratio) - Math.ceil(pointSize['width'] / 2); // distance
				newCoordinates['y'] = Math.ceil((1000 - $('#rank').val()) * ratio) - Math.ceil(pointSize['height'] / 2); // rank
				
			var memberId = $('#memberIdToChange').val();

                // Змінюю стилі:
				$('#member' + memberId).css('margin-left', newCoordinates['x'] + 'px');
				$('#member' + memberId).css('margin-top', newCoordinates['y'] + 'px');
				$('#span_member' + memberId).css('left', newCoordinates['x'] + 'px');
				$('#span_member' + memberId).css('top', newCoordinates['y'] + 'px');
                
                // Змінюю атрибути:
                $('#member' + memberId).attr({"distance":$('#distance').val(),"rank":$('#rank').val()})
				
		});
        
        
        
        // ------------------------------------------

     
  
</script>


