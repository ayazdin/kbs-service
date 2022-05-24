<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Category;

class CategoryController extends Controller
{
  public $depth = 0;
  public function index()
  {
    $categories = Category::all();
    $parent="";$cateTree="";
    $cateTree = $this->categoryTreeWalk('product', 'rdo', $parent);
    $categoryList = $this->categoryTreeWalk('product', 'list');
    return view('adminpanel.category.category')->with(compact('categories'))
                                                ->with(compact('cateTree'))
                                                ->with(compact('categoryList'));
  }

  public function createCategory($id="")
  {
    $category="";$cateTree="";$parent="";
    $categories = Category::all();
    if($id!="")
    {
      $category = Category::find($id);
      $parent = $this->getImmediateParent($id);
    }
    $cateTree = $this->categoryTreeWalk('product', 'rdo', $parent);
    $categoryList = $this->categoryTreeWalk('product', 'list');
    //echo $categoryList;
    return view('adminpanel.category.category')->with('category', $category)
                                        ->with(compact('categories'))
                                        ->with(compact('cateTree'))
                                        ->with(compact('categoryList'));
  }

  public function store(Request $request)
  {
    try {
        //$cmn = new CommonController();
        if($request['catid']!="")
            $postcat = Category::where('id', $request['catid'])->first();
        else
            $postcat = new Category();

        $postcat->name = $request['title'];

        $slug = $request['slug'];
        if(!empty($request['ctype']))
            $postcat->type = $request['ctype'];
        else
            $postcat->type = 'product';
        $postcat->slug = $this->getUniqueSlug($slug, $postcat->id);
        if($request['categories']!="")
          $postcat->parent = $request['categories'];
        else
          $postcat->parent = 0;
        $postcat->hash = $request['hashtag'];
        if($request['catid']!="")
        {
            $postcat->update();
            return redirect()->back()
                  ->with('success', 'Category updated successfully');
        }
        else
        {
            $postcat->save();
            return redirect()->back()
                  ->with('success', 'Category added successfully');
        }

    } catch ( Illuminate\Database\QueryException $e) {
        var_dump($e->errorInfo);
        return redirect()->back()
              ->with('error', 'Check if your slug is unique or not else contact your support team.');
    }
  }

  public function delete($id)
  {
    if($id>0)
    {
      Category::destroy($id);
      return redirect()->back()
            ->with('success', 'Category deleted successfully');
    }
    else {
      return redirect()->back()
            ->with('error', 'Category id cannot be 0');
    }
  }

  public function getCategoryList($cattype="",$list="", $sel="")
  {
      $categories="";
      $output="";
      $parents = $this->getParent($cattype);
      //print_r($sel);exit;
      if(!empty($parents)) {
          $categories = array();
          foreach($parents as $p)
          {
              $prod_sel='';
              if(is_array($sel) and in_array($p->id, $sel ))
                  $prod_sel='selected';
              elseif($sel==$p->id)
                  $prod_sel='selected';
              $subCat = $this->hasChild($p->id, $sel);
              if($subCat!==false)
                  $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel,  'subcategory' => $subCat);
              else
                  $categories[] = array('id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image, 'selected' => $prod_sel);
          }
      }

      if($list=="li"){
          $output="";
          if(!empty($categories))
          {//print_r($categories);exit;
              $output .= '<ul>';
              $output .= $this->getCategoryLi($categories, $sel);
              $output .= '</ul>';
          }
          //echo $output;exit;
          return $output;
      }
      if($list=="home"){
        $output="";
        if(!empty($categories))
        {
            $output .= '<ul list-unstyled components>';
            $output .= $this->getCategoryLiForHome($categories, $sel);
            $output .= '</ul>';
        }
        return $output;
      }
      else
          return $categories;
  }

  public function getParent($cattype="")
  {
      return Category::where('type', '=', $cattype)
          ->where('parent', '=', '0')
          ->get();
  }

  public function getImmediateParent($catid)
  {
    $cat = Category::where('id', '=', $catid)->first();
    if(!empty($cat))
      return $cat->parent;
    else
      return "";
  }

  public function getUniqueSlug($s, $catid="")
  {
      if($catid!="")
          $postcat = Category::where('slug', $s)
              ->where('id', '<>', $catid)
              ->first();
      else
          $postcat = Category::where('slug', $s)->first();
      if(!empty($postcat))
          return $postcat->slug."-".date('md');
      else
          return $s;
  }

  public function hasChild($id, $sel="")
  {
      //print_r($sel);
      $cat = array();
      $categories = Category::where('parent', '=', $id)->get();
      if(!empty($categories) and $categories!== false)
      {//print_r($categories);exit;
          foreach($categories as $category)
          {
              $prod_sel='';
              if(is_array($sel) and in_array($category->id, $sel))
                  $prod_sel='selected';
              elseif($sel==$category->id)
                  $prod_sel='selected';
              //$subCat = $this->hasChild($category->id);
              //$prodType = $this->getProductType($category->id, $sel);
              /*if($subCat!==false)
                $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'subcategory' => $subCat);
              else*/
              $cat[] = array('id' => $category->id, 'name' => $category->name, 'slug' => $category->slug, 'image' => $category->image, 'selected' => $prod_sel);
          }
          return $cat;
      }
      else
          return false;
  }

  public function categoryTreeWalk($type="category", $inp="", $sel="")
  {
    $html = '';
    $parents = $this->getParent($type);
    if(!empty($parents))
    {
      $pTot="";
      $iCount=0;
      $pTot=$parents->count();//echo "<br>";
      foreach($parents as $parent)
      {
        $optsel="";$optchk="";
        if(is_array($sel) and in_array($parent->id, $sel))
        {
          //$optsel = "selected";
          $optchk = "checked";
        }
        elseif($sel==$parent->id)
        {
          //$optsel = "selected";
          $optchk = "checked";
        }

        if($inp=='chk')
        {
          $html .= '<div class="pad-lft-0"><input type="checkbox" name="categories[]" value="'.$parent->id.'" '.$optchk.'> '.$parent->name;
          $html .= $this->getChild($parent->id, $inp, $sel).'</div>';
        }
        elseif($inp=='rdo')
        {
          $html .= '<div class="pad-lft-0"><input type="radio" name="categories" value="'.$parent->id.'" '.$optchk.'> '.$parent->name;
          $html .= $this->getChild($parent->id, $inp, $sel).'</div>';
        }
        elseif($inp=='array')
        {

        }
        else
        {
          $html .= '<tr>
            <td>'.$parent->name.'</td>
            <td class="text-right py-0 align-middle">
              <div class="btn-group btn-group-sm">
                <a href="/admin/category/edit/'.$parent->id.'" class="btn btn-info"><i class="fas fa-edit"></i></a>
                <a href="/admin/category/delete/'.$parent->id.'" class="btn btn-danger"><i class="fas fa-trash"></i></a>
              </div>
            </td>
          </tr>';
          $html .= $this->getChild($parent->id, $inp);
          $iCount++;
        }

      }
    }
    $this->depth=0;
    return $html;
  }

  public function getChild($pid, $inp, $sel="")
  {
    $html='';$pCount=0;
    //echo $this->depth."<br>";
    $cats = Category::where('parent', '=', $pid)->get();
    if(!empty($cats))
    {
      $this->depth=$this->depth+1;
      foreach($cats as $cat)
      {
        $optsel="";$optchk="";
        if(is_array($sel) and in_array($cat->id, $sel))
        {
          //$optsel = "selected";
          $optchk = "checked";
        }
        elseif($sel==$cat->id)
        {
          //$optsel = "selected";
          $optchk = "checked";
        }
        if($inp=='chk')
        {
          $html .= '<div class="pad-lft"><input type="checkbox" name="categories[]" value="'.$cat->id.'" '.$optchk.'> '.$cat->name;
          $html .= $this->getChild($cat->id, $inp, $sel).'</div>';
        }
        elseif($inp=='rdo')
        {
          $html .= '<div class="pad-lft"><input type="radio" name="categories" value="'.$cat->id.'" '.$optchk.'> '.$cat->name;
          $html .= $this->getChild($cat->id, $inp, $sel).'</div>';
        }
        else {
          $padval = $this->depth * 40;
          $padval = $padval."px";
          $html .= '<tr>
            <td style="padding-left:'.$padval.';">'.$cat->name.'</td>
            <td class="text-right py-0 align-middle">
              <div class="btn-group btn-group-sm">
                <a href="/admin/category/edit/'.$cat->id.'" class="btn btn-info"><i class="fas fa-edit"></i></a>
                <a href="/admin/category/delete/'.$cat->id.'" class="btn btn-danger"><i class="fas fa-trash"></i></a>
              </div>
            </td>
          </tr>';
          $html .= $this->getChild($cat->id, $inp);
        }
        $this->depth=$this->depth-1;
      }
    }

    return $html;
  }

  public function getCategoryLi($categories, $sel="")
  {
      $output = "";
      if(!empty($categories))
      {
          foreach($categories as $cat)
          {
              if($sel!="")
              {
                  if(in_array($cat['id'], $sel))
                      $output .='<li><label><input type="checkbox" name="category[]" checked value="'.$cat['id'].'"></label> '.$cat['name'];
                  else
                      $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
              }
              else
                  $output .='<li><label><input type="checkbox" name="category[]" value="'.$cat['id'].'"></label> '.$cat['name'];
              if(!empty($cat['subcategory']))
              {
                  $output .='<ul>';
                  $output .=$this->getCategoryLi($cat['subcategory'], $sel);
                  $output .='</ul></li>';
              }
              else
                  $output .= '</li>';
          }
      }
      return $output;
  }

  public function getCategoryLiForHome($categories, $sel="", $hassub="")
  {
    $output = "";
    if(!empty($categories))
    {
        foreach($categories as $cat)
        {
            $lnk = "";
            if(!empty($cat['subcategory']))
              $lnk .= '<a href="/category/'.$cat['slug'].'" class="bold">'.$cat['name'].'</a>';
            else
              $lnk .= '<a href="/category/'.$cat['slug'].'">'.$cat['name'].'</a>';
            if($sel!="")
            {
                if(in_array($cat['id'], $sel))
                    $output .= '<li class="active" data-target="#submenu'.$cat['id'].'" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle collapsed">';
                else
                    $output .= '<li>';
            }
            else
                $output .= '<li data-target="#submenu'.$cat['id'].'" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed">';
            $output .= $lnk;
            if(!empty($cat['subcategory']))
            {
              if(is_array($sel) and in_array($cat['id'], $sel))
                $output .='<ul class="collapse list-unstyled show" id="submenu'.$cat['id'].'">';
              else
                $output .='<ul class="collapse list-unstyled" id="submenu'.$cat['id'].'">';
                $output .=$this->getCategoryLiForHome($cat['subcategory'], $sel, "hassub");
                $output .='</ul></li>';
            }
            else
                $output .= '</li>';
        }
    }
    return $output;
  }

}
