<?php
SESSION_START();
include "Database.php";
$db = new Database();
if (!isset($_SESSION['id']) && !$_SESSION['is_login']) {
    header('Location:login.php');
}

?>
<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <title>DataTable - project3</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container">

        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>

        <div class="row">
            <div class="col-md-1"> </div>
            <div class="col-md-10">

                <div align="right">
                    <!-- Button trigger modal -->
                    <button type="button" id="openModal" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i>&nbsp; إضافة عنصر جديد
                    </button>
                </div>
                <div class="clearfix">&nbsp;</div>
            </div>
            <div class="col-md-1">
                <a type="button" href="logout.php" class="btn btn-danger">
                    <i class="fa "></i>&nbsp; تسجيل خروج
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">&nbsp; </div>
            <div class="col-md-10">
                <table class="table table-borderd table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col"> # </th>
                            <th scope="col"> اسم الجوال </th>
                            <th scope="col"> التصنيف </th>
                            <th scope="col"> السعر </th>
                            <th> الصورة </th>
                            <th scope="col">العملية </th>

                        </tr>
                    </thead>
                    <tbody id="show_data">
                        <?php
                        $sql = "SELECT * FROM `product_db`";
                        $rs = $db->dbQuery($sql);
                        ?>
                    </tbody>

                    <tfoot>
                        <tr class="table-info">
                            <th colspan="5" style="text-align: right;">عدد الصفوف</th>
                            <th><?= $db->dbNumRows($rs); ?></th>
                        </tr>
                        <tr>
                            <th scope="col"> # </th>
                            <th scope="col"> اسم الجوال </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> التصنيف </th>
                            <th> الصورة </th>
                            <th scope="col">العملية </th>
                        </tr>
                    </tfoot>

                </table>

            </div>
            <div class="col-md-1">&nbsp;</div>
        </div>
    </div>
    <script src="aa/js/jquery-3.6.0.min.js"></script>
    <script src="aa/js/bootstrap.min.js"></script>
    <script src="aa/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            show_userdata();
            $("#myTable").DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                }
            });

            function show_userdata() {
                $.ajax({
                    type: 'ajax',
                    url: 'get_ajax.php',
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        var html = '';
                        var image;
                        var category1;

                        for (i = 0; i < data.length; i++) {
                            if (data[i].image == '') {
                                image = "<img src='image/no-image.png' width='125' class='img-thumbail'>";
                            } else {
                                image = "<img src='image/" + data[i].image + "' width='125' class='img-thumbail'>";
                            }


                            if (data[i].category == 1) {
                                category1 = "أيفون";
                            } else if (data[i].category == 2) {
                                category1 = "شاومي";
                            } else {
                                category1 = "سامسونج";
                            }

                            html += '<tr>' +
                                '<td>' + data[i].id + '</td>' +
                                '<td>' + data[i].phone_name + '</td>' +
                                '<td>' + category1 + '</td>' +
                                '<td>' + data[i].price + '</td>' +
                                '<td>' + image + '</td>' +
                                '<td>' + "<a href = 'javascript:void(0)' id='edit_record' class = 'btn btn-info btn-sm edit_record' data-id= " + data[i].id + " data-phone_name=" + data[i].phone_name + " data-category=" + data[i].category + " data-price=" + data[i].price + " data-image=" + data[i].image + " > <i class='fa fa-pencil'></i> &nbsp;تعديل </a>" +
                                '&nbsp;' + "<a href = 'javascript:void(0)' id='delete_record' class = 'btn btn-danger btn-sm delete_record' data-id= " + data[i].id + "><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;  حذف </a>" + '</td></tr>';

                        }
                        $('#show_data').html(html);

                    }
                })
            }
            //add_pro
            $('#btn_add').click(function() {
                // var form = document.froms.namedItem('form1');
                var form = document.forms.namedItem('form1');

                var phone_name = $('#uphone_name').val();
                var category = $('#ucategory').val();
                var price = $('#uprice').val();
                var image = $('#uimage').val();
                // alert(image)
                if (uphone_name == '' || uprice == '' || ucategory == '') {
                    alert("الرجاء إدخال جميع الحقول السابقة");
                } else {
                    $.ajax({
                        url: "saverecord.php",
                        type: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: new FormData(form1),
                        success: function(data) {
                            console.log(data.image)
                            // هنا يوجد خطأ استبدل date ب data
                            if (data.status == true) {
                                alert(data.msg);
                            }
                            $('[name="uid"').val("");
                            $('[name="uphone_name"').val("");
                            $('[name="ucategory"').val("");
                            $('[name="uprice"').val("");
                            $('[name="uimage"').val("");
                            $('#exampleModal').modal('hide');
                            show_userdata();
                            location.reload();
                        }
                    })
                }
            })

            $("#openModal").click(function() {
                $('#exampleModal').modal('show');
            });

            $("#clsmodal,#clsmodals").click(function() {
                $('#exampleModal').modal('hide');
            });

            //edit_pro
            $('#show_data').on('click', '.edit_record', function() {
                var eid = $(this).data('id');
                var ephone_name = $(this).data('phone_name');
                var ecategory = $(this).data('category');
                var eprice = $(this).data('price');
                var eimage = $(this).data('image');
                // $('#Modal_edit').modal('show'); // هنا خطأ اسم المودال 
                $('#editModal').modal('show');

                $('[name="uid_edit"]').val(eid);
                $('[name="uphone_name_edit"]').val(ephone_name);
                $('[name="ucategory_edit"]').val(ecategory);
                $('[name="uprice_edit"]').val(eprice);
                // $('[name="old_image"]').val(eimage);
                if (eimage == '') {
                    $('#img2').html("<img src='image/no-image.png' width='125' class='img-thumbail'>");
                } else {
                    $('#img2').html("<img src='image/" + eimage + "' width='125' class='img-thumbail'>");
                }
            });


            $('#btn_edit').click(function(event) {

                var edit_pro = document.forms.namedItem('edit_pro');
                var eid = $('#uid_edit').val();
                console.log("value", eid);

                var ephone_name = $('#uphone_name_edit').val();
                console.log("uphone_name_edit", ephone_name);

                var ecategory = $('#ucategory_edit').val();
                console.log("ucategory_edit", ecategory);

                var eprice = $('#uprice_edit').val();
                console.log("eprice", eprice);

                var eimage = $('#uimage_edit').val();
                console.log("eimage", eimage);

                if (ephone_name == '' || eprice == '' || ecategory == '') {
                    alert("الرجاء إدخال جميع الحقول السابقة");
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'editrecord.php?id=' + eid,
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: new FormData(edit_pro),
                        success: function(data) {
                            console.log(data);

                            if (data.status == true) {
                                alert(data.msg);
                            }
                            // $('[name="uid_edit"]').val(eid); // Missing closing square bracket
                            // $('[name="uphone_name_edit"]').val(ephone_name); // Missing closing square bracket
                            // $('[name="ucategory_edit"]').val(ecategory); // Missing closing square bracket
                            // $('[name="uprice_edit"]').val(eprice); // Missing closing square bracket
                            // $('[name="uimage_edit"]').val(eimage); // Missing closing square bracket
                            show_userdata();
                            location.reload();
                            $('#editModal').modal('hide');

                        }
                    });
                }
            });

            // $("#edit_record").click(function() {
            //     $('#editModal').modal('show');
            // });

            $("#clsmodal1,#clsmodals1").click(function() {
                $('#editModal').modal('hide');
            });


            // Delete Record Data
            $('#show_data').on('click', '.delete_record', function() {
                var id = $(this).data('id');
                $('#deleteModale').modal('show');

                $('[name="delete_uid"]').val(id);
            });

            $('#delete_btn').on('click', function() {
                var id = $('#delete_uid').val();
                $.ajax({
                    type: 'post',
                    url: 'deleterecord.php?id=' + id,
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('[name="delete_uid"]').val("");
                        $('#deleteModale').modal('hide');
                        show_userdata();
                    }
                });
            });

            $("#delete_record").click(function() {
                $('#deleteModale').modal('show');
            });
            $("#clsmodal2,#clsmodals2").click(function() {
                $('#deleteModale').modal('hide');
            });

        });
    </script>
</body>

</html>

<!-- Add Modal Start -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة عنصر</h5>
                <button type="button" style="margin-left: 0px;" class="close" data-dismiss="modal" id="clsmodals" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <form id="form1">
                    <!-- <div class="form-group row">
                        <label for="inputId" class="col-sm-4 col-form-label">الرقم التسلسلي</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uid" name="uid">
                        </div>
                    </div>-->
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">اسم الجوال</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uphone_name" name="uphone_name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputMobile" class="col-lg-4 col-form-label">التصنيف </label>
                        <div class="col-lg-8">
                            <!-- <input type="text" class="form-control" id="ucategory"> -->
                            <select class="form-control" name="ucategory" id="ucategory">

                                <option value="" selected>أختر الصنف</option>
                                <option value="1">أيفون</option>
                                <option value="2">شاومي</option>
                                <option value="3">سامسونج</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputMobile" class="col-sm-4 col-form-label">السعر </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uprice" name="uprice">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputImage" class="col-sm-4 col-form-label">صورة الجوال </label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" id="uimage" name="uimage">
                        </div>
                    </div>
                </form>
                <div class="modal-footer" style="direction: ltr">
                    <button type="button" class="btn btn-danger" id="clsmodal" data-dismiss="modal">إغلاق</button>
                    <button type="button" id="btn_add" class="btn btn-success">إضافة عنصر</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal End -->

<!-- Eidt Modal Start -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل البيانات</h5>
                <button type="button" style="margin-left: 0px;" class="close" data-dismiss="modal" id="clsmodals1" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <form id="edit_pro">
                    <input type="hidden" id="old_image" name="old_image">
                    <div class="form-group row">
                        <label for="inputId" class="col-sm-4 col-form-label">الرقم التسلسلي</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uid_edit" name="uid_edit" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">اسم الجوال</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uphone_name_edit" name="uphone_name_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputMobile" class="col-lg-4 col-form-label">التصنيف </label>
                        <div class="col-lg-8">
                            <!-- <input type="text" class="form-control" id="ucategory"> -->
                            <select class="form-control" id="ucategory_edit" name="ucategory_edit">
                                <option value="" selected>أختر الصنف</option>
                                <option value="1">أيفون</option>
                                <option value="2">شاومي</option>
                                <option value="3">سامسونج</option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputMobile" class="col-sm-4 col-form-label">السعر </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="uprice_edit" name="uprice_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputImage" class="col-sm-4 col-form-label">صورة الجوال </label>
                        <div class="col-sm-8">
                            <div id="img2"> </div>
                            <div class="clearfix">&nbsp;</div>
                            <input type="file" class="form-control" id="uimage_edit" name="uimage_edit">
                        </div>
                    </div>
                </form>
                <div class="modal-footer" style="direction: ltr">
                    <button type="button" class="btn btn-danger" id="clsmodal1" data-dismiss="modal">إغلاق</button>
                    <button type="button" id="btn_edit" name="editrecord" class="btn btn-success"> تعديل البيانات</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Eidt Modal End -->

<!-- Delete Modal Start -->
<!-- Modal -->
<div class="modal fade" id="deleteModale" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">حذف </h5>
                <button type="button" class="btn-close" id="clsmodal2" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="text-align: right;">هل انت متأكد من حذف هذا العنصر؟</h5>
                <form>
                    <input type="hidden" name="delete_uid" id="delete_uid">
                </form>
            </div>
            <div class="modal-footer" style="direction: ltr;">
                <button type="button" class="btn btn-success" id="clsmodals2" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" id="delete_btn" class="btn btn-danger">حذف</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal End -->