package com.colors.supersaym.Views;

import java.util.ArrayList;

import android.R.menu;
import android.app.ProgressDialog;
import android.app.DownloadManager.Request;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.colors.supersaym.ChannelsAdapter;
import com.colors.supersaym.ImageLoader;
import com.colors.supersaym.R;
import com.colors.supersaym.controller.communication.AsyncTaskInvoker;
import com.colors.supersaym.controller.communication.ConnectionDetector;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.communication.Task.TaskID;
import com.colors.supersaym.controller.tasks.GuideTask;
import com.colors.supersaym.controller.tasks.TVChannels;
import com.colors.supersaym.dataobjects.ChannelData;
import com.colors.supersaym.dataprovider.DataRequestor;

public class GuideDetailsActivity extends Fragment implements DataRequestor {

	View rootView;
	ListView channelsListView;
	private ProgressDialog pDialog;
	ChannelsAdapter mAdapter;
	ImageView imgView;
	String id, url, name;
	ImageLoader imageLoader;
	TextView headerTxt;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		id = getArguments().getString("id");
		url = getArguments().getString("url");
		name = getArguments().getString("name");

		rootView = inflater.inflate(R.layout.activity_guide_details, container,
				false);
		init();
		return rootView;
	}

	private void init() {
		channelsListView = (ListView) rootView.findViewById(R.id.channelsList);
		imgView = (ImageView) rootView.findViewById(R.id.list_image);
		imageLoader = new ImageLoader(getActivity().getApplicationContext());
		imageLoader.displayImage(url, imgView);
		headerTxt = (TextView) rootView.findViewById(R.id.header_txt);
		headerTxt.setText(name);

		requestChannels();
	}

	private void requestChannels() {
		if (ConnectionDetector.getInstance(getActivity())
				.isConnectingToInternet()) {

			pDialog = new ProgressDialog(getActivity());
			pDialog.setIndeterminate(true);
			pDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			pDialog.setMessage("Loading...");
			pDialog.setCancelable(false);
			pDialog.show();
			Task task = new TVChannels(this, getActivity(), id);
			AsyncTaskInvoker.RunTaskInvoker(task);
		} else {
			Toast.makeText(getActivity(), "No Internet Connection",
					Toast.LENGTH_LONG).show();
		}
	}

	@Override
	public void onStart(Task task) {
		// TODO Auto-generated method stub

	}

	@Override
	public void onFinish(Task task) {
		if (task.getId() == TaskID.TVChannelsTask) {
			ArrayList<ChannelData> channelList = (ArrayList<ChannelData>) task
					.getResult();
			if (channelList.size() > 0) {
				mAdapter = new ChannelsAdapter(getActivity(), channelList);
				channelsListView.setAdapter(mAdapter);
			}
			pDialog.cancel();

		}
	}

}
