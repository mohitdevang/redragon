 <footer>
    <div class="copyright">
        <p>&copy; Copyright <?php echo date('Y');?>.
            <span class="lead">  {{ $setting->title }}</span>
        </p>
        <p>Last Login at : {{ date('F j, Y h:i:s', strtotime(Auth::guard('admin')->user()->last_login_at)) }} ( {{ config('app.timezone') }} )</p>
        <p>Last Login IP : {{ Auth::guard('admin')->user()->last_login_ip }}</p>
    </div>
    <div class="clearfix"></div>
</footer>
 

