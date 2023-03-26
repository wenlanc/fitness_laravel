  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <script src="{{ asset('dist/blackfit/js/jquery.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/popper.min.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/jquery.fancybox.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/appear.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/owl.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/wow.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/jquery-ui.js')}}"></script>
  <script src="{{ asset('dist/blackfit/js/script.js')}}"></script>
  <script src="{{ asset('dist/smartwizard/smartwizard.js') }}"></script>
  <script src="{{ asset('dist/validate/validate.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/front-common.js') }}"></script>

  <script>
    window.appConfig = {
      debug: "<?= config('app.debug') ?>",
      csrf_token: "<?= csrf_token() ?>"
    }
  </script>
