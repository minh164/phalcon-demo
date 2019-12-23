<!doctype html>
<!--[if IE 8]> <html lang="{{ language }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{{ language }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ language }}" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ locale.translate(get_title(false)) ~ " - " ~ config.get('app').get('name', 'Phalcon Framework') }}</title>
    {{- assets.outputCss('header_css') -}}
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    {% include 'admin/includes/navbar.volt' %}
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    {% include 'admin/includes/sidebar.volt' %}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {% block page_header %} {% endblock %}
        </section>

        <!-- Main content -->
        <section class="content">
            {% block content %} {% endblock %}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.1
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

    {{- assets.outputJs('footer_js') -}}
    {% block after_js %} {% endblock %}
</body>
</html>
