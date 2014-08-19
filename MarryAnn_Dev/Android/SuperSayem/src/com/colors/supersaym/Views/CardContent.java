package com.colors.supersaym.Views;

import com.colors.supersaym.R;
import com.colors.supersaym.R.id;
import com.colors.supersaym.R.layout;
import com.colors.supersaym.Adapters.ImgPager;
import android.R.string;
import android.annotation.SuppressLint;
import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.os.Build;

@SuppressLint("ValidFragment") public class CardContent extends Fragment {
	View rootView;
	ViewPager pager;
	private Context parentcon;

	public CardContent(Context con) {
		this.parentcon = con;
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		rootView = inflater.inflate(R.layout.activity_card_content, container,
				false);
		init();
		return rootView;
	}

	private void init() {
		pager = (ViewPager) rootView.findViewById(R.id.pager);
		String[] urls = {
				"http://hitseven.net/mobile/assets/cards/mosalslat/2/img.png",
				"http://hitseven.net/mobile/assets/cards/shahryar/3/img.png",
				"http://hitseven.net/mobile/assets/cards/manElQatel/5/img.png" };
		ImgPager adapter = new ImgPager(getActivity(), urls);
		pager.setAdapter(adapter);

	}

}
