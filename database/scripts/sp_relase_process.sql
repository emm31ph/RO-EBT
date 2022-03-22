DELIMITER $$
DROP PROCEDURE IF EXISTS sp_release_process;$$
CREATE PROCEDURE sp_release_process ( 
  IN ro_no varchar(100),
  IN res int
)
BEGIN
IF res = 0 THEN
   

select 
  releasetfi.Customer, 
  releasetfi.docno,
  releasetfi.PO_no,
  releaseprocess.deliver_date as 'deliverydate',
  releaseprocess.created_at as 'processdate',
  releaseprocess.area as 'area',
  releaseprocess.plate as 'plate',
  releaseprocess.truckno as 'truckno',
  releaseprocess.driver as 'driver',
  releaseprocess.ro_no as 'releaseno',
  releaseprocess.remarks as 'remarks',
    
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data01') then rt.qty else 0 end) as 'data01',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data02') then rt.qty else 0 end) as 'data02',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data03') then rt.qty else 0 end) as 'data03',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data04') then rt.qty else 0 end) as 'data04',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data05') then rt.qty else 0 end) as 'data05',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data06') then rt.qty else 0 end) as 'data06',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data07') then rt.qty else 0 end) as 'data07',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data08') then rt.qty else 0 end) as 'data08',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data09') then rt.qty else 0 end) as 'data09',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data10') then rt.qty else 0 end) as 'data10',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data11') then rt.qty else 0 end) as 'data11',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data12') then rt.qty else 0 end) as 'data12',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data13') then rt.qty else 0 end) as 'data13',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data14') then rt.qty else 0 end) as 'data14',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data15') then rt.qty else 0 end) as 'data15',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data16') then rt.qty else 0 end) as 'data16',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data17') then rt.qty else 0 end) as 'data17',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data18') then rt.qty else 0 end) as 'data18',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data19') then rt.qty else 0 end) as 'data19',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data20') then rt.qty else 0 end) as 'data20',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data21') then rt.qty else 0 end) as 'data21',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data22') then rt.qty else 0 end) as 'data22',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data23') then rt.qty else 0 end) as 'data23',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data24') then rt.qty else 0 end) as 'data24',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data25') then rt.qty else 0 end) as 'data25',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data26') then rt.qty else 0 end) as 'data26',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data27') then rt.qty else 0 end) as 'data27',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data28') then rt.qty else 0 end) as 'data28',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data29') then rt.qty else 0 end) as 'data29',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data30') then rt.qty else 0 end) as 'data30',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data31') then rt.qty else 0 end) as 'data31',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data32') then rt.qty else 0 end) as 'data32',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data33') then rt.qty else 0 end) as 'data33',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data34') then rt.qty else 0 end) as 'data34',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data35') then rt.qty else 0 end) as 'data35',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data36') then rt.qty else 0 end) as 'data36',

  sum(rt.qty) as 'qtyTotal'
  from releasetfi rt
  inner join release_items ri on ri.releasetfi_id=rt.id
  inner join releaseprocess rp on rp.id=ri.releaseprocess_id
  where rp.ro_no=ro_no 
  and rp.status not BETWEEN '90' and '99'
  and rt.U_STOCKCODE in (select content from reportitems where  (replace(code,'data','') * 1 ) BETWEEN 1 and 36 )
  group by rt.Customer, rt.docno,rt.PO_no;
END IF;


  IF res = 1 THEN
select rt.Customer, rt.docno,rt.PO_no,
  rp.deliver_date as 'deliverydate',
  rp.created_at as 'processdate',
  rp.area as 'area',
  rp.plate as 'plate',
  rp.truckno as 'truckno',
  rp.driver as 'driver',
  rp.ro_no as 'releaseno',
  rp.remarks as 'remarks',
    
  sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data101') then rt.qty else 0 end) as 'data01',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data102') then rt.qty else 0 end) as 'data02',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data103') then rt.qty else 0 end) as 'data03',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data104') then rt.qty else 0 end) as 'data04',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data105') then rt.qty else 0 end) as 'data05',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data106') then rt.qty else 0 end) as 'data06',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data107') then rt.qty else 0 end) as 'data07',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data108') then rt.qty else 0 end) as 'data08',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data109') then rt.qty else 0 end) as 'data09',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data110') then rt.qty else 0 end) as 'data10',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data111') then rt.qty else 0 end) as 'data11',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data112') then rt.qty else 0 end) as 'data12',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data113') then rt.qty else 0 end) as 'data13',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data114') then rt.qty else 0 end) as 'data14',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data115') then rt.qty else 0 end) as 'data15',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data116') then rt.qty else 0 end) as 'data16',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data117') then rt.qty else 0 end) as 'data17',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data118') then rt.qty else 0 end) as 'data18',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data119') then rt.qty else 0 end) as 'data19',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data120') then rt.qty else 0 end) as 'data20',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data121') then rt.qty else 0 end) as 'data21',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data122') then rt.qty else 0 end) as 'data22',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data123') then rt.qty else 0 end) as 'data23',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data124') then rt.qty else 0 end) as 'data24',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data125') then rt.qty else 0 end) as 'data25',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data126') then rt.qty else 0 end) as 'data26',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data127') then rt.qty else 0 end) as 'data27',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data128') then rt.qty else 0 end) as 'data28',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data129') then rt.qty else 0 end) as 'data29',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data130') then rt.qty else 0 end) as 'data30',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data131') then rt.qty else 0 end) as 'data31',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data132') then rt.qty else 0 end) as 'data32',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data133') then rt.qty else 0 end) as 'data33',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data134') then rt.qty else 0 end) as 'data34',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data135') then rt.qty else 0 end) as 'data35',
 sum(case  when rt.U_STOCKCODE in (select content from reportitems where code='data136') then rt.qty else 0 end) as 'data36',


sum(rt.qty) as 'qtyTotal'
  from releasetfi rt
  inner join release_items ri on ri.releasetfi_id=rt.id
  inner join releaseprocess rp on rp.id=ri.releaseprocess_id
  where rp.ro_no=ro_no  
  and rp.status not BETWEEN '90' and '99'
  and rt.U_STOCKCODE in (select content from reportitems where (replace(code,'data','') * 1 ) BETWEEN 101 and 136 )
  group by rt.Customer, rt.docno,rt.PO_no;
END IF;



END$$
DELIMITER ;