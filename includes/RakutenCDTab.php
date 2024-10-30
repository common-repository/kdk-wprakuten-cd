<?php
class RakutenCDTab implements IRakutenMediaTab {
	function getName()
	{
		return 'CDs';
	}

	public function getFields() {
		return array(
				//デベロッパーID
				'__developerId' => '%%%RAKUTEN%%%DEV_ID%%%',
				//アフィリエイトID
				'__affiliateId' => '%%%RAKUTEN%%%AFF_ID%%%',
				//操作
				'__operation' => 'BooksCDSearch',
				//バージョン
				'__version' => '2011-12-01',
				//検索キーワード
				'title' => null,
				//アーティスト名/作曲者名等
				'artistName' => null,
				//発売元名
				'label' => null,
				//CDのJANコード
				'jan' => null,
				//取得ページ
				'__hits' => 30,
				'__page' => 1,
				'availability' => array(0,1,2,3,4,5,6),
				'__outOfStockFlag' => array(0,1),
				//ソート
				'sort' => array(
						'standard',
						'sales',
						'+releaseDate',
						'-releaseDate',
						'+itemPrice',
						'-itemPrice',
						'reviewCount',
						'reviewAverage'
				),
				'limitedFlag' => array(0,1),
				'__carrier' => array(0,1),
				'__genreInformationFlag' => array(0,1)
		);
	}

	public function displayFields() {
		return array(
				'id'    => 'jan',
				'catchcopy' => 'playList',
				'description'=>'itemCaption',
				'shopName' => 'label',
				'shopUrl' => '',
				'imageFlag'  => '',
				'imageUrl' => 'mediumImageUrl',
				'thumbUrl' => 'smallImageUrl',
				'title' => 'title',
				'price' => 'itemPrice',
				'salePrice' => 'listPrice',
				'affiliateUrl' => 'affiliateUrl',
				'url' => 'itemUrl',
				'affiliateRate' => 'affiliateRate',
				'reviewCount' => 'reviewCount',
				'reviewAverage' => 'reviewAverage',
				'other' => array(
						'availability',
						'postageFlag',
						'limitedFlag',
						'booksGenreId'

				)
		);
	}


	public function shortCodeName() {
		return 'rakute_cd';
	}

	public function doShortcode($raw_args, $content=null)
	{
		wp_enqueue_script( 'jquery' );
		$template = apply_filters("rakuten_template","template1");
		$codeName = $this->shortCodeName();

		$defaults = array (
				'id' => '',
		);
		$spanitized_args = shortcode_atts($defaults, $raw_args);

		if (empty($spanitized_args['id']))
			return '';

		$display_fields = $this->displayFields();

		$metadata[$display_fields['id']] = $spanitized_args['id'];
		$metadata['operation'] = 'BooksCDSearch';
		$metadata['version'] = '2011-12-01';
		$metadata['developerId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%DEV_ID%%%');
		$metadata['affiliateId'] = apply_filters('rakuten_str_replace','%%%RAKUTEN%%%AFF_ID%%%');

		$get_data['rakuten_title'] = $display_fields['title'];
		$get_data['rakuten_price'] = $display_fields['price'];
		$get_data['rakuten_description'] = $display_fields['description'];
		$get_data['rakuten_url'] = $display_fields['affiliateUrl'];
		$get_data['rakuten_photo'] = $display_fields['imageUrl'];

		$json = json_encode(array('param'=>$metadata,'display'=>$get_data));

		return str_replace("[+rakuten_jsondata+]", $json, $template);
	}

	public function __toString()
	{
		return 'kdk-wprakuten-cd';
	}
}