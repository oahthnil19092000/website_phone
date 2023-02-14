
function xuly1(){
    document.getElementsByClassName('modal')[0].style.display="block";
    document.getElementById('login-form').style.display="block";
    document.getElementById('register-form').style.display="none";
}
function xuly2(){
    document.getElementsByClassName('modal')[0].style.display="block";
    document.getElementById('login-form').style.display="none";
    document.getElementById('register-form').style.display="block";
}
function chuyentrang(a){
    var b = document.getElementsByClassName('grid__row1');
    for(var i= 0 ; i< b.length ; i++){
        b[i].style.display="none";
    }
    document.getElementById('page'+a).style.display="flex";
    document.getElementsByClassName('home-filter__page-current')[0].innerText=a;
    if(a==b.length){
        document.getElementById('nextpage').className="home-filter__page-btn home-filter__page-btn--disabled";
        document.getElementById('prepage').className="home-filter__page-btn";
    } else
    if(a==1){
        document.getElementById('prepage').className="home-filter__page-btn home-filter__page-btn--disabled";
        document.getElementById('nextpage').className="home-filter__page-btn";
    } else {
        document.getElementById('prepage').className="home-filter__page-btn";
        document.getElementById('nextpage').className="home-filter__page-btn";
    }
        
}
function nextpage(){
    var b = document.getElementsByClassName('grid__row1');
    if(b[b.length-1].style.display=="none")
    for(var i= b.length-1 ; i>=0  ; i--){
        if(b[i].style.display=="flex"){
            b[i].style.display="none";
            b[i+1].style.display="flex";
            document.getElementsByClassName('pagepage')[i+1].checked="true";
            document.getElementsByClassName('home-filter__page-current')[0].innerText=(i+2);
            if(i+1==b.length-1)
                document.getElementById('nextpage').className="home-filter__page-btn home-filter__page-btn--disabled";
            if(i==0)
                document.getElementById('prepage').className="home-filter__page-btn";
        }
        
    }
}
function prepage(){
    var b = document.getElementsByClassName('grid__row1');
    if(b[0].style.display=="none")
    for(var i= 0 ; i < b.length  ; i++){
        if(b[i].style.display=="flex"){
            b[i].style.display="none";
            b[i-1].style.display="flex";
            document.getElementsByClassName('pagepage')[i-1].checked="true";
            document.getElementsByClassName('home-filter__page-current')[0].innerText=(i);
            if(i-1==0)
                document.getElementById('prepage').className="home-filter__page-btn home-filter__page-btn--disabled";
            if(i==b.length-1)
                document.getElementById('nextpage').className="home-filter__page-btn";
        }
    }
}
function hienmota(th){
    if(document.getElementById('chitietmota').className=='chitietmota'){
        document.getElementById('chitietmota').className='chitietmota-on';
        document.getElementById('hiensp').style.display="none";
        th.innerText="Ẩn mô tả";
    } else {
        document.getElementById('chitietmota').className='chitietmota';
        th.innerText="Hiện mô tả";
        document.getElementById('hiensp').style.display="block";
    }
    
}
function them(n){
    var a = document.getElementById('soluong');
    if(a.value<n)
    a.value++ ;
}
function bot(){
    var a = document.getElementById('soluong');
    if(a.value>1)
    a.value-- ;
}