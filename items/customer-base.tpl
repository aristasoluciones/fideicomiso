{foreach from=$customers item=item key=key}
	<tr>
		<td align="center">{$item.customerId}</td>
		<td align="center">{$item.nameContact|wordwrap:20:"<br />\n":TRUE}</td>
        <td align="center">{$item.phone|wordwrap:20:"<br />\n":TRUE}</td>
        <td align="center">{$item.email|wordwrap:20:"<br />\n":TRUE}</td>
            
        <td align="center">{$item.password|wordwrap:20:"<br />\n":TRUE}</td>        
				<td align="center" class="id">
        {if $item.active == 1 || $item.active ==0}
					{if $item.contracts.0.fake == 1}
                    	0
                    {else}
                                        {$item.contracts|count}         

                    {/if}	
          {if $item.contracts|count > 0}
        		<a href="{$WEB_ROOT}/contract/id/{$item.customerId}"><img src="{$WEB_ROOT}/images/icons/view.png" title="Ver Razones Sociales"/> </a>
          {/if}
          {if $infoUser.tipoPersonal != "Gerente" || $infoUser.tipoPersonal != "Supervisor"}
        		<a href="{$WEB_ROOT}/contract-new/id/{$item.customerId}"><img src="{$WEB_ROOT}/images/icons/add.png" title="Agregar Razon Social"/></a>
          {/if}
        {else}
        N/A
        {/if}
        </td>
        <td align="center">{if $item.active}Si{else}No{/if}</td>
        <td align="center">{$item.fechaAlta|date_format:"d-m-Y"}</td>
			{if $User.roleId < 3}
		<td align="center">      
      {if $infoUser.tipoPersonal != "Recepcion"}
        {if $item.active == 1}
          <img src="{$WEB_ROOT}/images/icons/action_delete.gif" class="spanDelete" id="{$item.customerId}" title="Desactivar"/> 
        {else}
          <img src="{$WEB_ROOT}/images/icons/activate.png" class="spanDelete" id="{$item.customerId}" title="Activar"/> 
        {/if}  
          
         <img src="{$WEB_ROOT}/images/icons/edit.gif" class="spanEdit" id="{$item.customerId}" title="Editar"/>
       {/if}  
		</td>
       {/if}
	</tr>
{foreachelse}
<tr><td colspan="6" align="center">No se encontr&oacute; ning&uacute;n registro.</td></tr>
{/foreach}
