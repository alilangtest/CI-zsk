<form method="post">
<table  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td>
    <table width="500" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" >
      <tr>
        
        <td height="40" width="150" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">旧密码</span></div></td>
        <td width="150" bgcolor="#FFFFFF" class="STYLE19"><div align="center"><input type="password" name="oldpass" id="oldpass"></input></div></td>
        
        
      </tr>
      <tr>
        
        <td height="40" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">新密码</span></div></td>
        <td bgcolor="#FFFFFF" class="STYLE19"><div align="center"><input type="password" name="newpassword" id="newpassword"></input></div></td>
        
      </tr>
      <tr>
        
        <td height="40" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">重复新密码</span></div></td>
        <td bgcolor="#FFFFFF" class="STYLE19"><div align="center"><input type="password" name="repassword" id="repassword"></input></div></td>
        
      </tr>
      <tr>
      	<td bgcolor="#FFFFFF" height="70" colspan="2"><input type="submit" value="确认提交" style="margin-left: 200px;margin-top: 10px;"/></td>
      </tr>
    </table>
    <table style="float: left;margin-top: 50px;" border="0">
    	<tr>
    		<td height="40" width="200"><font color="red" size="2"><?php echo form_error('oldpass'); ?></font></td>
    	</tr>
    	<tr>
    		<td height="40" width="200"><font color="red" size="2"><?php echo form_error('newpassword'); ?></font></td>
    	</tr>
    	<tr>
    		<td height="40" width="200"><font color="red" size="2"><?php echo form_error('repassword'); ?></font></td>
    	</tr>
    </table>
    
    </td>
  </tr>
</table>
</form>
<script type="text/javascript">
<?php if(isset($msg) && $msg != ''){?>
	alert("<?php echo $msg;?>");
<?php }?>

</script>