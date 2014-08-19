package com.colors.supersaym.tabs;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import com.colors.supersaym.Views.*;

public class TabsPagerAdapter extends FragmentPagerAdapter {

	public TabsPagerAdapter(FragmentManager fm) {
		super(fm);
	}

	@Override
	public Fragment getItem(int index) {

		switch (index) {
		case 0:
			return new MeActivity();
		case 1:
			return new EpisodesActivity();
		case 2:
			return new ScoreboardActivity();
		case 3:
			return new NotificationActivity();
		case 4:
			return new GuideActivity();

		}

		return null;
	}

	@Override
	public int getCount() {
		// get item count - equal to number of tabs
		return 5;
	}

}
