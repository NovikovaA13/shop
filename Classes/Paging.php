<?php 
class Paging
{
	protected $numberOfLines;
	protected $page;
	protected $nameTable;
	protected $limit;
	protected $content;
	protected $paging;
	protected $subCategoryId;
	protected $categoryTitle;
	
	
	public function __construct($numberOfLines, $page, $nameTable, $subCategoryId = null, $categoryTitle = null){
		
		$this->numberOfLines = $numberOfLines;
		$this->page = $page;
		$this->nameTable = $nameTable;
		$this->limit = ($this->page - 1) * $this->numberOfLines;
		
		if (isset($subCategoryId)){
			
			$this->subCategoryId = $subCategoryId;
			$this->categoryTitle = $categoryTitle;
		}
		return $this;
	}
	public function showPage(){
		
		$this->content = '';
		$sql = new SQL();
		if (isset($this->subCategoryId)){
			
			$data = $sql->selectWithLimitAndCond($this->nameTable, "{$this->limit}, {$this->numberOfLines}", ['subCategoryId' => $this->subCategoryId], 'id DESC');

		}
		else{
			
			$data = $sql->selectAllWithLimit($this->nameTable, " {$this->numberOfLines}", 'RAND()');

		}
		
		foreach ($data as $el) {
								
			
			 $this->content .= "<div class=\"col-lg-4 col-md-6 mb-4\">
              <div class=\"card h-100\">
               <img class=\"card-img-top\" src=\"images1/$el[image]\" alt=\"\">
                <div class=\"card-body\">
                  <h4 class=\"card-title\">
                   $el[name]
                  </h4>
                  <h5>$ $el[price]</h5>
                  <p class=\"card-text\">$el[info]</p>
                </div>
                <div class=\"card-footer\">
                  <a href=\"basket.php?id=$el[id]\">Add to Basket</a> 
                </div>
              </div>
            </div>";
								
		}
		return $this->content;
	}
	
	public function showPaging(){
		
		$this->paging = '';		
		$countSQL = new SQL();
		
		if (isset($this->subCategoryId)){
			
			$allRows = $countSQL->countLinesWithCond('product', ['subCategoryId' => $this->subCategoryId]);
			
		}
		else{
			$allRows = $countSQL->countLines('product');
		}
		$allPages = ceil($allRows / $this->numberOfLines);

		if ($this->page > 1) {
			$previous = $this->page - 1;
			$classDisabled = '';
		}
		else {
			
			$previous = 1;
			$classDisabled = ' disabled';
		}
			$this->paging .= "<li class=\" page-item $classDisabled\"><a href=\"?page=$previous\" tabindex=\"-1\" class=\"page-link\" aria-label=\"Previous\">
					<span aria-hidden=\"true\">&laquo;</span>
				</a></li>";
			
			for ($i = 1; $i <= $allPages; $i++){
				
				if ($i == $this->page){
					
					$class =' active';
				}
				else {
					
					$class = '';
				}
				if ($this->subCategoryId == 0){
					
					$line = $this->categoryTitle = 'index.php?';
					
				}
				else {
					$line = "$this->categoryTitle&cid=$this->subCategoryId";
				}
				$line .= "&page=$i";
				$line = str_replace("?&", "?", $line);
				$this->paging .= "<li class=\"page-item $class\"><a class=\"page-link\" href=\"$line\">$i</a></li>";
			}
			
			if ($this->page < $allPages) {
				
			$next = $this->page + 1;
			$classDisabled = '';
			}
			else {
				$next = $this->page;
				$classDisabled = 'disabled';
			}
			
			
			$this->paging .= "<li class =\"page-item $classDisabled\"><a href=\"?page=$next\" class=\"page-link\" aria-label=\"Next\>
					<span aria-hidden=\"true\">&raquo;</span>
				</li></a>										
			</li>";
		return $this->paging;
	}
	
	

}