
class Screenshot{
    constructor(canvas){
        
        this.canvas = canvas;
        this.ctx = this.canvas.getContext('2d');

    }

    show(){

        $(this.canvas).css({"position":"absolute", "top":"0px", "left":"0px"});
        document.body.appendChild(this.canvas);
        return this;
    }

    draw_line(){
        this.ctx.strokeStyle = 'red';
        this.ctx.lineWidth = 5;

        // draw a red line
        this.ctx.beginPath();
        this.ctx.moveTo(100, 100);
        this.ctx.lineTo(300, 100);
        this.ctx.stroke();

    }


}
var screenshot_obj;

$(document).ready(function(){

    setTimeout(function(){
        html2canvas(document.body).then(function(canvas) {
            screenshot_obj = new Screenshot(canvas);
            document.body.appendChild(canvas);
        });
    },1000)

    

});


var screenshot;

function draw() {

    if (!screenshot.getContext) {
        return;
    }
    const ctx = screenshot.getContext('2d');

    // set line stroke and line width
    ctx.strokeStyle = 'red';
    ctx.lineWidth = 5;

    // draw a red line
    ctx.beginPath();
    ctx.moveTo(100, 100);
    ctx.lineTo(300, 100);
    ctx.stroke();

}
