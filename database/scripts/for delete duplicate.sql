DELETE t1 FROM release_items t1
INNER JOIN release_items t2 
WHERE 
    t1.releaseprocess_id < t2.releaseprocess_id AND 
    t1.releasetfi_id = t2.releasetfi_id;