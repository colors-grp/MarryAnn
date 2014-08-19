package com.colors.supersaym.Adapters;

import android.app.ActionBar.LayoutParams;
import android.content.Context;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.GridView;
import android.widget.ImageView;

import com.colors.supersaym.R;

public class ImageAdapter extends BaseAdapter {
	private Context mContext;
	onItemClicked listener;
	 int selectedPosition;
	public interface onItemClicked
	{
		void cardSelected(int position);
	}
	public ImageAdapter(Context c,onItemClicked listener) {
		mContext = c;
		this.listener=listener;
	}

	public int getCount() {
		return 30;
	}

	public Object getItem(int position) {
		return null;
	}

	public long getItemId(int position) {
		return 0;
	}

	// create a new ImageView for each item referenced by the Adapter
	public View getView( int position, View convertView, ViewGroup parent) {
		ImageView imageView;
		selectedPosition=position;
		if (convertView == null) { // if it's not recycled, initialize some
									// attributes
			imageView = new ImageView(mContext);
			imageView.setLayoutParams(new GridView.LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
			imageView.setScaleType(ImageView.ScaleType.FIT_XY);
			imageView.setPadding(8, 8, 8, 8);
		} else {
			imageView = (ImageView) convertView;
		}

		imageView.setImageResource(R.drawable.closedcard);
		imageView.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View arg0) {
				listener.cardSelected(selectedPosition);			
			}
		});
		return imageView;
	}


}