package com.colors.supersaym.Adapters;

import android.content.Context;
import android.os.Parcelable;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.ImageView.ScaleType;

public class ImgPager extends PagerAdapter {
	Context imgContext;
	String[] urls;

	public ImgPager(Context context, String[] imgUrls) {
		imgContext = context;
		urls = imgUrls;
	}

	@Override
	public int getCount() {
		return urls.length + 1;
	}

	@Override
	public Object instantiateItem(ViewGroup container, int position) {
		if (position < urls.length) {
			ImageView view = new ImageView(imgContext);
			view.setLayoutParams(new LayoutParams(LayoutParams.FILL_PARENT,
					LayoutParams.FILL_PARENT));
			view.setScaleType(ScaleType.FIT_XY);
			new DownLoadImage(view).execute(urls[position]);
			((ViewPager) container).addView(view, 0);
			return view;

		} 

		else {
			LinearLayout lay=new LinearLayout(imgContext);
			lay.setLayoutParams(new LayoutParams(LayoutParams.FILL_PARENT,
					LayoutParams.FILL_PARENT));	
			
			TextView view = new TextView(imgContext);
			view.setText("Question text");
			view.setLayoutParams(new LayoutParams(LayoutParams.WRAP_CONTENT,
					LayoutParams.WRAP_CONTENT));	
			lay.addView(view);
			((ViewPager) container).addView(lay, 0);

			return lay;

		}
	}

	@Override
	public void destroyItem(View arg0, int arg1, Object arg2) {
		((ViewPager) arg0).removeView((View) arg2);
	}

	@Override
	public boolean isViewFromObject(View arg0, Object arg1) {
		return arg0 == ((View) arg1);
	}

	@Override
	public Parcelable saveState() {
		return null;
	}
}