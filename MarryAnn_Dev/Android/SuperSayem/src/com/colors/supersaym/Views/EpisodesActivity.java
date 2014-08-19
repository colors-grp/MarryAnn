package com.colors.supersaym.Views;


import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.colors.supersaym.R;
import com.colors.supersaym.R.drawable;
import com.colors.supersaym.R.id;
import com.colors.supersaym.R.layout;
import com.colors.supersaym.R.string;
import com.uberspot.a2048.MainActivity;

public class EpisodesActivity extends Fragment {
	ImageView alfleila, mnqatel, mosalsalat, sallyseyamak;
	TextView headerTxt;
	private View rootView;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		 rootView = inflater.inflate(R.layout.activity_episodes, container, false);
		
		initUI();

		return rootView;
	}

	private void initUI() {
		headerTxt = (TextView)rootView. findViewById(R.id.header_txt);
		headerTxt.setText(R.string.episodes);
		
		alfleila = (ImageView) rootView.findViewById(R.id.alfleila);
		mnqatel = (ImageView) rootView.findViewById(R.id.mnqatel);
		mosalsalat = (ImageView) rootView.findViewById(R.id.mosalsalat);
		sallyseyamak = (ImageView) rootView.findViewById(R.id.sallyseyamak);

		alfleila.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				alfleila.setImageResource(R.drawable.alfleilaselected);
				mnqatel.setImageResource(R.drawable.mnqatel);
				mosalsalat.setImageResource(R.drawable.mosalsalat);
				sallyseyamak.setImageResource(R.drawable.sallyseyamak);
				alfLilaFragment alfLila = new alfLilaFragment(getActivity());
				addContentFragment(alfLila, true);
				
			}
		});
		
		mnqatel.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				alfleila.setImageResource(R.drawable.alfleila);
				mnqatel.setImageResource(R.drawable.mnqatelselected);
				mosalsalat.setImageResource(R.drawable.mosalsalat);
				sallyseyamak.setImageResource(R.drawable.sallyseyamak);
			}
		});
		
		mosalsalat.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				alfleila.setImageResource(R.drawable.alfleila);
				mnqatel.setImageResource(R.drawable.mnqatel);
				mosalsalat.setImageResource(R.drawable.mosalsalatselected);
				sallyseyamak.setImageResource(R.drawable.sallyseyamak);
			}
		});
		
		sallyseyamak.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				alfleila.setImageResource(R.drawable.alfleila);
				mnqatel.setImageResource(R.drawable.mnqatel);
				mosalsalat.setImageResource(R.drawable.mosalsalat);
				sallyseyamak.setImageResource(R.drawable.sallyseyamakselected);
				openGames();
			}

			
		});
				
	}
	private void openGames() {
		Intent game=new Intent(getActivity(),com.uberspot.a2048.MainActivity.class);
		startActivity(game);
	}

	

	public void addContentFragment(Fragment fragment, boolean addToBackStack) {
		FragmentManager fManager = getActivity().getSupportFragmentManager();
		Fragment currentFragment = fManager.findFragmentByTag(fragment
				.getClass().getName());
		if (currentFragment == null) {
			FragmentTransaction fTransaction = fManager.beginTransaction();
			fTransaction.replace(R.id.content_fram, fragment, fragment
					.getClass().getName());
			if (addToBackStack) {
				fTransaction.addToBackStack(null);
			}
			fTransaction.commit();
		}
	}

	

}
