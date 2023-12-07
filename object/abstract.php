<?php

//抽象クラス abstractを先頭につける
//設定するメソッドを強制する
abstract class ProductAbstract{ //先頭は大文字
    //変数　関数
    //★抽象クラス内は、public関数もつかるよ
    public function echoProduct(){
        echo '親クラスです';
    }

    //抽象メソッド　absotractを先頭につける
    //abstractつけると中にかけない　エラーになる。関数名だけ書ける
    //★抽象クラスで設定してる抽象メソッドは、必ず使用する必要ある
    abstract public function getProduct();
        //echo '親の関数です。';
    //}
}


//具象クラス
abstract class ProductAbstract{ //先頭は大文字
    //変数　関数
    public function echoProduct(){
        echo '親クラスです';
    }

    //オーバーライド（上書き）
    public function getProduct(){
        echo '親の関数です。';
    }
}

//子クラス・派生クラス・サブクラス
//final class Product extends BaseProduct
//final このクラスからは継承できませんよ
//★抽象クラスは継承できるのひとつだけ
class Product extends ProductAbstract{ //先頭は大文字

    //アクセス修飾子
    //priveate(外からアクセスできない。変数とか)
    //protected(自分・継承したクラスのみつかえる)
    //public(公開。インスタンスして使うとき)


    //変数（プロパティ）
    private $product = []; //privateなので、$Product->product = 10;　とかでの実行はエラーでる。


    //関数（メソッド）
    function __construct($product){ //__constructで初回に起動する関数として設定

        //thisはProductクラスのこと。
        //$this->productは、private $product = [];のこと。
        //メソッドアクセスは＄つけないで$->productにする。
        $this->product = $product;
    }


    //★抽象クラスで設定してる抽象メソッドは、必ず使用する必要ある
    //表示する動的メソッド（メソッド＝クラス内の関数のこと）
    //final public function getProduct(){　//このクラスの関数からは継承できませんよ
    // parent:: //名前が被っていて、親の名前を使いたいときに使用
    public function getProduct(){
        echo $this->product;
    }

    //追加する動的メソッド
    public function addProduct($item){
        $this->product .= $item; // .=で追加の意味
    }

    //静的メソッド
    //静的（static）クラス名::関数名
    public static function getStaticProduct($str){
        echo $str;
    }


}


//インスタンス化
$instance = new Product('テスト'); //private $productに「テスト」が入ってるインスタンス

echo '<pre>';
var_dump($instance); //オブジェクトが入ってる
echo '<pre>';

$instance->getProduct(); //「テスト」が表示される
echo '<br>';


//親クラスのメソッド
$instance->echoProduct();
echo '<br>';


$instance->addProduct('追加分'); //「追加文」が、private $productに追加される。
echo '<br>';

$instance->getProduct(); //「テスト」「追加分」　が表示される
echo '<br>';

//静的クラスを実行。「静的」が表示される。
//インスタンスを作らずに実行できる
Product::getStaticProduct('静的');
echo '<br>';