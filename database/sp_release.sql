DELIMITER $$
DROP PROCEDURE IF EXISTS sp_release;$$
CREATE PROCEDURE sp_release ( 
  IN pi_docno varchar(100)
)
BEGIN
 
SELECT  sd.docno,
              sd.bpname AS 'Customer',
              REPLACE(sd.billtoaddress,'Philippines','') AS 'Address',
              sp.salespersonname AS 'Sales',
              sd.u_sono AS 'SO_no',
              sd.bprefno AS  'PO_no',
              sd.u_pono as 'PO',
              sd.docdate AS 'Date',
              cc.name AS 'Attention',
              sdi.quantity AS 'Qty',
              #IF(i.remarks <> '',CONCAT(sdi.itemdesc,'\n ',i.remarks),CONCAT(sdi.itemdesc)) AS 'Description',
       sdi.itemdesc AS 'Description',
       uv.fieldvaluedesc AS 'Stock_Condition',
              sdi.unitprice AS 'Unit_price',
             sdi.linetotal-sdi.vatamount AS 'Amount',
              sdi.vatamount 'VAT_Amount',
              sdi.linetotaldisc 'Discounted_Amount',
              pt.paymenttermname AS 'Terms',
              sdi.uom as 'Unit',
              tb.fieldvaluedesc,
              sdi.discperc AS 'Line_Discount',
          sd.discperc AS 'Percentage_Disc',
          sd.discamount,
          sdi.u_qty_service 
      ,i.itemcode,i.U_STOCKCODE,m.MAKENAME
  
FROM arinvoices sd
LEFT JOIN arinvoiceitems sdi ON sdi.company = sd.company
      AND sdi.branch = sd.branch
      AND sdi.docid = sd.docid
 LEFT JOIN items i ON i.itemcode = sdi.itemcode
 LEFT JOIN makes m on m.MAKE=i.MAKE
LEFT JOIN customercontacts cc ON cc.contactperson = sd.contactperson
      AND cc.custno = sd.bpcode
LEFT JOIN salespersons sp ON sp.salesperson = sd.salesperson
LEFT JOIN paymentterms pt ON pt.paymentterm = sd.paymentterm
LEFT JOIN users u ON u.userid = sd.createdby
LEFT OUTER JOIN udfvalues tb ON tb.tablename = 'salesdeliveries'
      AND tb.fieldname = 'approver'
      AND tb.fieldvalue = u_approver
LEFT JOIN udfvalues uv ON uv.fieldvalue = sdi.u_stockcondition
      AND uv.fieldname = 'stockcondition'
      AND uv.tablename = 'arinvoiceitems'
WHERE   sd.docno = pi_docno or sd.bprefno=pi_docno;

END$$
DELIMITER ;
