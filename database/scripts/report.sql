select 
  rt.Qty,
  rpt.*
  from releasetfi rt
  inner join release_items ri on ri.releasetfi_id=rt.id
  inner join releaseprocess rp on rp.id=ri.releaseprocess_id
  left join report_item rpt on rpt.itemcode=rt.U_STOCKCODE
  where rp.ro_no=15587  
  and rp.status not BETWEEN '90' and '99'
 order by type, case rpt.header1 
  
  when 'Swan Sardines' then '0'

  when 'Señorita' then '1'
  when 'Toyo Sardines' then '2' 
  when 'OBT' then '3' 
  when 'Mayon' then '4' else '5' end asc