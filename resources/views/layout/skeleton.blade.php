<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/ac243a383f.js" crossorigin="anonymous"></script>
  {{-- <script src="{{ asset('js/tailwindconfig.js') }}"></script> --}}
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'navy-primary': '#153A8F',
            'navy-secondary': '#0E3166',
            'yellow-primary': '#FFDE16',
            'yellow-secondary': '#FFE5B4',
          },
        },
        container: {
          padding: {
            DEFAULT: '1rem',
            sm: '2rem',
            lg: '4rem',
            xl: '5rem',
            '2xl': '6rem',
          },
        },
      },
    };
  </script>

<body class="text-gray-900 bg-gray-50">
  @yield('body')
</body>

</html>
