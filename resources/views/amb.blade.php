<style>
    .hidden {
        visibility: hidden;
        display: none;
    }
    .alert-row{
        position: fixed;
        width: auto;
        right: 0;
        top: 10px;
        padding: 0;
        margin: 0;
    }
    .alert-box {
        display: block;
        width: fit-content;
        margin: 15px;
        border-radius: 10px;
        border: solid;
        padding: 15px 30px;
    }
    .alert-box.show {
        animation: showAlert 1s ease forwards;
    }
    @keyframes showAlert{
        0%{
            transform: translateX(100%);
        }
        40%{
            transform: translateX(-15%);
        }
        80%{
            transform: translateX(0%);
        }
        100%{
            transform: translateX(-10px);
        }
    }
    .alert-box.hide {
        animation: hideAlert 1s ease forwards;
    }
    @keyframes hideAlert{
        0%{
            transform: translateX(-10px);
        }
        40%{
            transform: translateX(0%);
        }
        80%{
            transform: translateX(-15%);
        }
        100%{
            transform: translateX(120%);
        }
    }
    #green_alert, .green_alert{
        background: #47d300;
        border-color: #308f00;
        color: #000;
        box-shadow: 1px 5px 10px 1px #47d300;
    }
    #green_alert .sub_alert_box_end_show , .green_alert .sub_alert_box_end_show {
        background: #56ff00;
    }
    #red_alert, .red_alert{
        background: #C91524;
        border-color: #9d0f1b;
        color: #fff;
        box-shadow: 1px 5px 10px 1px #C91524;
    }
    #red_alert .sub_alert_box_end_show , .red_alert .sub_alert_box_end_show {
        background: #ff1b2e;
    }
    #gold_alert, .gold_alert{
        background: #ffd700;
        border-color: #ffc107;
        color: #000;
        box-shadow: 1px 5px 10px 1px #ffd700;
    }
    #gold_alert .sub_alert_box_end_show , .gold_alert .sub_alert_box_end_show {
        background: #ffea59;
    }
    #blue_alert, .blue_alert{
        background: #0000FF;
        border-color: #00008B;
        color: #fff;
        box-shadow: 1px 5px 10px 1px #0000FF;
    }
    #blue_alert .sub_alert_box_end_show , .blue_alert .sub_alert_box_end_show {
        background: #007FFF;
    }
    
    .sub_alert_box_end_show{
        content: '';
        position: absolute;
        left: 2%;
        bottom: 0;
        box-sizing border-box;
        z-index: 11;
        animation: hideMeter 3.5s linear;
        height: 4px;
    }
    @keyframes hideMeter{
        0%{
            width: 98%;
        }
        100%{
            width: 0%;
        }
    }
</style>
<div class="alert-row" id="alert_row"></div>
<script>

    function wait_alert(){
        show_alert("gold","لطفا صبر کنید ...");
    }
    var alert_counter = 0;
    function show_alert(color,text){
        
        alert_counter++;
        var alert_color = color+"_alert";
        var alert_row = document.getElementById('alert_row'),
        alertBox = document.createElement('div');
        alertBox.setAttribute("class","alert-box close-alert hide hidden "+alert_color+" alert_count"+alert_counter);
        alertBox.setAttribute("id","alert_count"+alert_counter);
        alertBox.innerHTML = text+"<div class=\"sub_alert_box_end_show\" id=\"sub_alert_box_end_show"+alert_counter+"\"></div>";
        alert_row.appendChild(alertBox);
        
        let timer;
        alertBox.classList.remove("hide");
        alertBox.classList.add("show");
        if(alertBox.classList.contains("hidden")){
            alertBox.classList.remove("hidden");
        }
        var time_to_delete = 3500;
        var time_to_delete_show = 3.5;
        var text_lenth = text.length;
        if(text_lenth > 35){
            time_to_delete = text_lenth * 100;
            time_to_delete_show = text_lenth/10;
        }
        document.getElementById("sub_alert_box_end_show"+alert_counter).style.animationDuration = time_to_delete_show+"s";
        timer=setTimeout(function(){
            hideAlertBox();
        },time_to_delete)
        timer=setTimeout(function(){
            removeAlertBox();
        },time_to_delete+1000)
        function hideAlertBox(){
            alertBox.classList.remove("show");
            alertBox.classList.add("hide");
        }
        function removeAlertBox(){
            alertBox.remove();
        }
    }
    function format_number(n){
        if(n < 1000){
            return n;
        }
        n = parseInt(n);
        n = n+"";
        var c = n.length;
        var mod_c = c%3;
        var r = "";
        var i,j;
        for(i=0;i<mod_c;i++){
            r = r+n[i];
        }
        if(i>0){
            r = r+",";
        }
        for(j=1;i<c;i++,j++){
            r = r+n[i];
            if((j%3)==0 && i<(c-1)){
                r = r+",";
            }
        }
        return r;
    }

</script>
