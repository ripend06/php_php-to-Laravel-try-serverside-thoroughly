<?php

//インターフェース
//設定するメソッドを強制する
Interface ProductInterface{ //先頭は大文字
    //変数　関数
    //★インターフェース内は、public関数つかえない
    //★メソッドの強制しか書けない
    // public function echoProduct(){
    //     echo '親クラスです';
    // }

    //★メソッドしか書けない
    public function getProduct();
}


//インターフェース
//設定するメソッドを強制する
Interface NewsInterface{ //先頭は大文字
    //変数　関数
    //★インターフェース内は、public関数つかえない
    //★メソッドの強制しか書けない
    // public function echoProduct(){
    //     echo '親クラスです';
    // }

    //★メソッドしか書けない
    public function getNews();
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
//★インターフェースを使うときは、implementsを使う
//★インターフェースの場合は複数継承できる
//★抽象クラスは継承できるのひとつだけ
class Product implements ProductInterface, NewsInterface { //先頭は大文字

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

    public function getNews(){
        echo 'ニュースです';
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
// $instance->echoProduct();
// echo '<br>';


$instance->addProduct('追加分'); //「追加文」が、private $productに追加される。
echo '<br>';

$instance->getProduct(); //「テスト」「追加分」　が表示される
echo '<br>';


$instance->getNews(); //「追加文」が、private $productに追加される。
echo '<br>';


//静的クラスを実行。「静的」が表示される。
//インスタンスを作らずに実行できる
Product::getStaticProduct('静的');
echo '<br>';