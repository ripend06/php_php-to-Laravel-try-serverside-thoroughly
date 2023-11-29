<?php

function validation($request){

    $errors = []; //ローカル変数なので外側からアクセスできない。外側で指定する必要ある

    //氏名バリデーション
    if(empty($request['your_name']) || 20 < mb_strlen($request['your_name'])){ //your_nameが空または、２０文字以上だったら処理
        $errors[] = '「氏名」は必須です。２０文字以内で入力してください。';
    }

    //性別バリデーション
    if(!isset($request['gender'])){ //emptyだと、０の場合も判定されちゃうので、isset使う。　genderが入っていなかったら処理
        $errors[] = '「性別」は必須です。';
    }

    //年齢バリデーション
    if(empty($request['age']) || 6 < $request['age']){ //年齢が空または、６より大きかったら処理。６はselectのvalue
        $errors[] = '「年齢」は必須です。';
    }

    //メールアドレスバリデーション
    if(empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ //emailが空または、emailのフィルターじゃなければ処理。簡易的にするために、filter_varを使用。
        $errors[] = '「メールアドレス」は必須です。正しい形式で入力してください。';
    }

    //URLバリデーション
    //空の場合は処理しない
    if(!empty($request['url'])){ //URLが空ではなかったら、URLのフィルターじゃなければ処理。簡易的にするために、filter_varを使用。
        if(!filter_var($request['url'], FILTER_VALIDATE_URL)){
            $errors[] = '「ホームページ」は正しい形式で入力してください。';
        }
    }

    //お問い合わせバリデーション
    if(empty($request['contact']) || 20 < mb_strlen($request['contact'])){ //your_nameが空または、２０文字以上だったら処理
        $errors[] = '「お問い合わせ」は必須です。200文字以内で入力してください。';
    }

    //注意事項バリデーション
    if(empty($request['caution'])){ //注意事項が空だったら処理
        $errors[] = '「注意事項」をご確認ください。';
    }

    return $errors;
}
?>