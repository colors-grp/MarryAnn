package com.colors.supersaym.Views;


import android.annotation.SuppressLint;
import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ListView;

import com.colors.supersaym.R;
import com.colors.supersaym.Adapters.ImageAdapter;
import com.colors.supersaym.Adapters.ImageAdapter.onItemClicked;

@SuppressLint("ValidFragment")
public class alfLilaFragment extends Fragment implements onItemClicked{

	private Context parentcon;
	private View layout;
	ImageView alfleila;

	public alfLilaFragment(Context paContext) {
		this.parentcon = paContext;
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		layout = inflater.inflate(R.layout.alf_lila_eb, container,
				false);

		   GridView gridview = (GridView)layout.findViewById(R.id.gridview);
		    gridview.setAdapter(new ImageAdapter(this.getActivity(),this));

		   ;
		return layout;
	}
	
	public void addContentFragment(Fragment fragment, boolean addToBackStack) {
		FragmentManager fManager = getActivity().getSupportFragmentManager();
		Fragment currentFragment = fManager.findFragmentByTag(fragment
				.getClass().getName());
		if (currentFragment == null) {
			FragmentTransaction fTransaction = fManager.beginTransaction();
			fTransaction.replace(R.id.grid_content, fragment, fragment
					.getClass().getName());
			if (addToBackStack) {
				fTransaction.addToBackStack(null);
			}
			fTransaction.commit();
		}
	}

	@Override
	public void cardSelected(int position) {
		CardContent alfLila = new CardContent(getActivity());
		addContentFragment(alfLila, true);		
	}

}
