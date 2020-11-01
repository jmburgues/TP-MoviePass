<?php
  namespace DB\PDO;
  
  abstract class QueryType{
    const Query = 0;
    const StoredProcedure = 1;
  }
?>