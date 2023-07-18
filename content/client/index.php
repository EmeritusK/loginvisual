<?php
session_start();

require_once '../api/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../login.php");
    exit;
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Estudiantes CRUD</title>
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="https://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
</head>
<body>
    <h2>Reporte de Estudiantes CRUD</h2>
    <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
    <table id="dg" title="Lista de Estudiantes" class="easyui-datagrid" style="width:700px;height:250px"
            url="../api/get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="CEDULA" width="50">CEDULA</th>
                <th field="NOMBRE" width="50">NOMBRE</th>
                <th field="APELLIDO" width="50">APELLIDO</th>
                <th field="EDAD" width="50">EDAD</th>
                <th field="TELEFONO" width="50">TELEFONO</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Nuevo Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Editar Usuario</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Eliminar Usuario</a>   
        <a href="fpdf/Reporte.php" class="btn-generar-reportes">Generar Reportes</a>
        <a href="jasper/reporte/ReportJasper.php" class="btn-generar-reportes-jasper">Generar Reportes Jasper</a>


    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
            <h3>User Information</h3>
            <div style="margin-bottom:10px">
                <input name="CEDULA" class="easyui-textbox" required="true" label="CEDULA:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="NOMBRE" class="easyui-textbox" required="true" label="NOMBRE:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="APELLIDO" class="easyui-textbox" required="true" label="APELLIDO:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EDAD" class="easyui-textbox" required="true" label="EDAD:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="TELEFONO" class="easyui-textbox" required="true" label="TELEFONO:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">GUARDAR</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">CANCELAR</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
            $('#fm').form('clear');
            url = '../api/save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = '../api/update_user.php?id='+row.CEDULA;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                iframe: false,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    if (r){
                        $.post('../api/destroy_user.php',{CEDULA:row.CEDULA},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>
        <a href="../../logout.php">Cerrar sesión</a>   
</body>
</html>