<?php get_header(); ?>

	<main class="ly-contents p-page-404">
		<section class="p-page-404">
			<div class="inner">
				<div class="p-title">
					<h1><span class="en">Not Found</span> <span class="jp">ページが見つかりませんでした。</span></h1>
				</div>
				<p class="p-text-01">
					ページが移動または削除された可能性があります。<br class="is-pc">
					お手数ですが、再度トップページからのアクセスをお願いします。
				</p>
				<div class="p-btn">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ</a>
				</div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>

