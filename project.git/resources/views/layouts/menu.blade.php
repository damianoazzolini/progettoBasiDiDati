
<div class="header">
    <div id="headerLeft">
		<a href="/home">
         <div id="headerLogo"><img src="{{ asset('/systemImages/logo.png') }}"/></div>
         </a>
    </div>
    
   
    <div id="headerRight">
        <ul>
            <li><a href="/profilo">
                <div id="profilo">
                    <div id="corniceProfilo" style="background: url({{Auth::user()->immagine}}) 50% 0 / cover no-repeat white; width: 50px;"></div>
                    <div id="nomeProfilo">{{Auth::user()->nome}}</div>
                </div>
                </a>
            </li>
            <li><a href="/home"><img src="{{ asset('/systemImages/home.svg') }}" style="width: 30px"/></a></li>
            <li><a href="/chat"><img src="{{ asset('/systemImages/messaggi.svg') }}" style="width: 30px"/></a></li>
            <li><a href="/amici"><img src="{{ asset('/systemImages/amici.svg') }}" style="width: 30px"/></a></li>
            <li><a href="/richieste_amicizia"><img src="{{ asset('/systemImages/richieste.svg') }}" style="width: 30px"/></a></li>
            <li><a href="/notifiche"><img src="{{ asset('/systemImages/notifiche.svg') }}" style="width: 30px"/></a></li>
            <li>
                <!-- Logout deve essere POST -->
                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><img src="{{ asset('/systemImages/logout.svg') }}" style="width: 25px"/></a>
            
                <form id="frm-logout" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>  
    </div>
</div>
