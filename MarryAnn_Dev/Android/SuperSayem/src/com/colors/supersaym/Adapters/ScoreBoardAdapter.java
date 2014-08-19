package com.colors.supersaym.Adapters;


import java.util.ArrayList;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.colors.supersaym.R;
import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.storage.ImageLoader;
import com.facebook.widget.ProfilePictureView;



public class ScoreBoardAdapter extends BaseAdapter {
ArrayList<UserData>originalData;
private static LayoutInflater inflater = null;
public ImageLoader imageLoader;
private Activity activity;


public ScoreBoardAdapter(Activity parentActivity,ArrayList<UserData>arraySData)
{
	activity=parentActivity;
	inflater = (LayoutInflater) parentActivity
			.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
	originalData=arraySData;
	imageLoader = new ImageLoader(parentActivity.getApplicationContext());
}
	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return originalData.size();
	}

	@Override
	public Object getItem(int position) {
		// TODO Auto-generated method stub
		return originalData.get(position);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View vi = convertView;
		if (convertView == null)
			vi = inflater.inflate(R.layout.score_board_item, null);

		TextView name = (TextView) vi.findViewById(R.id.userName); // title

		TextView score = (TextView) vi.findViewById(R.id.userScore); // artist name
		TextView rank = (TextView) vi.findViewById(R.id.userRank); // artist name
		ProfilePictureView	profilePictureView = (ProfilePictureView)vi.findViewById(R.id.userimage);

														// image
		UserData data = originalData.get(position);
		// Setting all values in listview
		name.setText(data.name);
		score.setText(data.score);
		rank.setText(data.rank);
		profilePictureView.setProfileId(data.fbid);
		return vi;
	}

}
