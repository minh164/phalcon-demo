{% extends 'admin/layouts/main.volt' %}

{% block page_header %}
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update {{ blog_info.title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
{% endblock %}

{% block content %}
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create blog</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <form action="{{ route.getUri('admin.blog.update', blog_info.blog_id) }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                {% if flash.has('error') == true %}
                    <div class="alert alert-danger">
                        {{  flash.output(true) }}
                    </div>
                {% endif %}
                {% if flash.has('success') == true %}
                    <div class="alert alert-success">
                        {{  flash.output(true) }}
                    </div>
                {% endif %}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Categories</label>
                            <select name="category_id" class="form-control select2" style="width: 100%;">
                                <option selected="selected">Thể loại 1</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Title</label>
                            <input value="{{ blog_info.title }}" name="title" type="text" class="form-control" placeholder="Enter ...">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="3" placeholder="Enter ...">{{ blog_info.content }}</textarea>
                        </div>

                        <div class="form-group">
                            <img src="/{{ blog_info.image }}" width="150" height="150">
                            <label>Image</label>
                            <input type="file" name="image">
                        </div>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.card-footer-->
        </form>
    </div>
    <!-- /.card -->
{% endblock %}

{% block after_js %}
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        })
    </script>
{% endblock %}
