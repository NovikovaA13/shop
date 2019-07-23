<?php 
class Menu
{
	protected $nav;

	
	public function __construct(){
		$this->content = '';	
		
		return $this;
	}

	public function createLink($id, $title) {		
	
		$this->content .= "<a class=\"dropdown-item\" href=\"$title&cid=$id\">$title</a>";

	}
	public function showMenu(){
		
		$sql = new SQL ();
		$result = $sql->selectAll('category');

		foreach($result as $elem){
				$this->content .=  "<li class=\"nav-item dropdown\">	
					<a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" data-subMenu=\"\" aria-expanded=\"false\">
					  $elem[title]<span class = \"caret\"></span>
					</a>
				<div class=\"dropdown-menu\">";
				$sqlSub = new SQL ();
				$resultSubMenu = $sqlSub->selectWithCondition('subcategory', "categoryId=$elem[id]");
				foreach($resultSubMenu as $elemSubMenu){
					$this->createLink($elemSubMenu["id"], $elemSubMenu["title"]);
				}
				$this->content .= '</div></li>';  
		}

		 return $this->content;
	}
	public function showSelectSubcategory(){
		
		$sql = new SQL ();
		$result = $sql->selectAll('subcategory');
		if (!empty($result)) {
			$this->content .= '<select name="subcategory">';	
				foreach ($result as $data){
					
						$this->content .= "<option value=\"$data[id]\" name=\"$data[title]\"> $data[title]</option>";
					
				}
			
			$this->content .= '</select>';
		}
		return $this->content;
	}
	
	public function showAdminMenuCategory(){
		$this->content = '<h3>Menu</h3>';
		$sql = new SQL();
		$reqSubCategory = $sql->selectAll('subcategory');
		$this->content .= "<table class=\"table table-striped table-bordered\">";
		foreach ($reqSubCategory as $lineSubCategory){
			
			$this->content .= "<tr><td><a class=\"dropdown-item\" href=\"adminCategory.php?id=$lineSubCategory[id]\">Modify The Product Of The Category: $lineSubCategory[title]</a></td></tr>";			
			
		}
		$this->content .= '</table>';
		return $this->content;
	}
	
	public function showAdminMenu($subCategoryId){
		$sql = new SQL();
		$reqProducts = $sql->selectWithCondition('product', "subCategoryId=$subCategoryId", 'id DESC');
		$this->content	= '<table><th>ID</th>
		<th>IMAGE</th>
		<th>NAME</th>
		<th>PRICE</th>
		<th>INFO</th>		
		<th>DELETE_X</th>
		<th>MODIFY_X</th>
		</tr>';
		foreach ($reqProducts as $rowProduct){
			$product = new Product($rowProduct['id']);
			$info = $product->getInfo();
			$image = $product->getImage();
			$productId = $product->getProductId();
			$price = $product->getPrice();
			$name = $product->getName();
			$this->content .= "<tr>
			<td>$productId</td>
			<td><img src=\"images1/$image\" class=\"smallimage\"></td>
			<td>$name</td>
			<td>$price $</td>
			<td class=\"small\">$info</td>
			
			<td><a href=\"adminProduct.php?modifyProductId=$productId\">Modify</a></td>
			<td><a href=\"?deleteId=$productId\">Delete</a></td>
			</tr>";
		}
		return $this->content .= '</table>';

	}


	public function showAdminUsersPage($userId){
		$sqlUsersStatus = new SQL();
		
		$reqUsers = $sqlUsersStatus->selectWithCondition('users', "id != $userId");
		
		$this->content .= '<table><tr>
		<th>Login</th>
		<th>Status</th>
		<th>Change status X</th>
		<th>Delete X</th>
		<th>Ban X</th>
		</tr>';
		foreach ($reqUsers as $data) {
			
			$class = "class=\"$data[status]\"";
		
			if ($data["banned"] == 1) {
				$titleBanned = "Unban This User";
			}
			else {
				$titleBanned = "Ban This User";
			}
			
			if ($data["status"] == 1) {
				$titleStatus = "Change status Of This User To User";
			}
			else {
				$titleStatus = "Change status Of This User To Admin";
			}
			
			$this->content .= "<tr $class>
			<td>$data[login]</td>
			<td>$data[status]</td>
			<td><a href=\"?changeStatus=$data[id]\">$titleStatus</a></td>
			<td><a href=\"?deleteId=$data[id]\">Delete This User</a></td>
			<td><a href=\"?bannedId=$data[id]\">$titleBanned</a></td>
			</tr>";
		}

		$this->content .= "</table>";

		return $this->content;
	}
	public function showAdminPage($idUser){
		$sql = new SQL();
		$result = $sql->selectWithCondition('product', "userId = $idUser", 'id DESC');
		
		
		if ($result){
			$this->content .= '<table class=\"table-striped padding\"><thead padding>
			<th padding>Id</th>
			
			<th padding>Text</th>
			<th padding>To top </th>
			<th padding>Delete</th>
			</thead>';
			foreach ($result as $data){
			
				$text = mb_substr(trim($data['text']), 0, 300).'...';
				$this->content .= "<tr class=\"padding\">
				<td class=\"padding\">$data[id]</td>
				
				<td class=\"padding\">$text</td>
				<td class=\"padding\"><a href=\"?topId=$data[id]\">Top up annonce X</a></td>
				<td class=\"padding\"><a href=\"?deleteId=$data[id]\">Delete X</a></td>
				
				</tr>";
		}

		$this->content .= '</table>';
		}
		
		return $this->content;
	}
	
}