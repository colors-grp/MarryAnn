package com.colors.supersaym.tabs;

import android.content.Context;
import android.content.res.Resources;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.view.ViewPager;
import android.support.v4.view.ViewPager.OnPageChangeListener;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TabHost;
import android.widget.TabHost.OnTabChangeListener;
import android.widget.TextView;

import com.colors.supersaym.R;

public class HomeActivity extends FragmentActivity implements
		OnTabChangeListener, OnPageChangeListener {

	private TabsPagerAdapter mAdapter;
	private ViewPager mViewPager;
	private TabHost mTabHost;
	private String me, episodes, scoreboard, notification, guide;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_home);

		mViewPager = (ViewPager) findViewById(R.id.viewpager);

		// Tab Initialization
		initialiseTabHost();
		mAdapter = new TabsPagerAdapter(getSupportFragmentManager());
		// Fragments and ViewPager Initialization

		mViewPager.setAdapter(mAdapter);
		mViewPager.setOnPageChangeListener(HomeActivity.this);
		Resources ressources = getResources();
		me = ressources.getString(R.string.me);
		episodes = ressources.getString(R.string.episodes);
		scoreboard = ressources.getString(R.string.scoreboard);
		notification = ressources.getString(R.string.notification);
		guide = ressources.getString(R.string.guide);

	}

	// Method to add a TabHost
	private static void AddTab(HomeActivity activity, TabHost tabHost,
			TabHost.TabSpec tabSpec, String text, int resId) {

		tabSpec.setContent(new MyTabFactory(activity)).setIndicator(
				prepareTabView(text, resId, activity));
		tabHost.addTab(tabSpec);

	}

	// Manages the Tab changes, synchronizing it with Pages
	public void onTabChanged(String tag) {
		int pos = this.mTabHost.getCurrentTab();
		this.mViewPager.setCurrentItem(pos);
	}

	@Override
	public void onPageScrollStateChanged(int arg0) {
	}

	// Manages the Page changes, synchronizing it with Tabs
	@Override
	public void onPageScrolled(int arg0, float arg1, int arg2) {
		int pos = this.mViewPager.getCurrentItem();
		this.mTabHost.setCurrentTab(pos);
	}

	@Override
	public void onPageSelected(int arg0) {
	}

	// Tabs Creation
	private void initialiseTabHost() {
		mTabHost = (TabHost) findViewById(android.R.id.tabhost);
		mTabHost.setup();

		// TODO Put here your Tabs
		HomeActivity.AddTab(this, this.mTabHost,
				this.mTabHost.newTabSpec("ButtonTab"), "Me",
				R.drawable.me_icon_tab);
		HomeActivity.AddTab(this, this.mTabHost,
				this.mTabHost.newTabSpec("ButtonTab"), "Episodes",
				R.drawable.episodes_icon_tab);
		HomeActivity.AddTab(this, this.mTabHost,
				this.mTabHost.newTabSpec("ButtonTab"), "Scoreboard",
				R.drawable.scoreboard_icon_tab);
		HomeActivity.AddTab(this, this.mTabHost,
				this.mTabHost.newTabSpec("ButtonTab"), "Notification",
				R.drawable.notifications_icon_tab);
		HomeActivity.AddTab(this, this.mTabHost,
				this.mTabHost.newTabSpec("ButtonTab"), "Guide",
				R.drawable.guide_icon_tab);

		mTabHost.setOnTabChangedListener(this);
	}

	private static View prepareTabView(String text, int resId, Context c) {
		View view = LayoutInflater.from(c).inflate(R.layout.tabs, null);
		ImageView iv = (ImageView) view.findViewById(R.id.TabImageView);
		TextView tv = (TextView) view.findViewById(R.id.TabTextView);
		iv.setImageResource(resId);
		tv.setText(text);
		return view;
	}
}