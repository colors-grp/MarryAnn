package com.colors.supersaym.Views;

import java.util.ArrayList;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ListView;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;
import android.support.v4.app.Fragment;

import com.colors.supersaym.R;
import com.colors.supersaym.Adapters.ScoreBoardAdapter;
import com.colors.supersaym.controller.communication.AsyncTaskInvoker;
import com.colors.supersaym.controller.communication.ConnectionDetector;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.tasks.AllScoreBoardTask;
import com.colors.supersaym.controller.tasks.FriendsScoreboard;
import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.storage.UIManager;

public class ScoreboardActivity extends Fragment implements DataRequestor {

	TextView headerTxt;
	ListView scoreBoardList;
	ScoreBoardAdapter mAdapter;
	ProgressDialog mSpinnerProgress;
	SharedPreferences appPreferences;
	private View rootView;
	Context cont;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.activity_scoreboard, container,
				false);
		appPreferences = getActivity().getSharedPreferences(
				Constants.appPreferencesName, Context.MODE_PRIVATE);
		initUI();

		return rootView;
	}

	private void initUI() {
		headerTxt = (TextView) rootView.findViewById(R.id.header_txt);
		headerTxt.setText(R.string.scoreboard);
		scoreBoardList = (ListView) rootView.findViewById(R.id.scroreBoardList);
		RadioGroup radiogroub = (RadioGroup) rootView
				.findViewById(R.id.radioGroup);
		RadioButton all = (RadioButton) rootView.findViewById(R.id.all);
		all.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				requestdata();
			}
		});
		RadioButton friends = (RadioButton) rootView.findViewById(R.id.friends);
		friends.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				requestFriendList();

			}
		});

		requestdata();
		// scroreBoardList
	}

	private void requestFriendList() {
		if (ConnectionDetector.getInstance(getActivity())
				.isConnectingToInternet()) {
			mSpinnerProgress = new ProgressDialog(getActivity());
			mSpinnerProgress.setIndeterminate(true);
			mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			mSpinnerProgress.setMessage("Loading ....");
			mSpinnerProgress.show();
			Log.d("Shaimaa",
					"FB USerID "
							+ appPreferences.getString(Constants.userID, ""));

			Task scoreboard = new FriendsScoreboard(this, getActivity(),
					appPreferences.getString(Constants.userID, ""), "1",
					"sallySyamak", 0, 10,appPreferences.getString(UIManager.accountId, ""));
			AsyncTaskInvoker.RunTaskInvoker(scoreboard);
		} else {
			Toast.makeText(getActivity(), "No Internet Connection",
					Toast.LENGTH_LONG).show();
		}

	}

	private void requestdata() {

		if (ConnectionDetector.getInstance(getActivity())
				.isConnectingToInternet()) {
			mSpinnerProgress = new ProgressDialog(getActivity());
			mSpinnerProgress.setIndeterminate(true);
			mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			mSpinnerProgress.setMessage("Loading ....");
			mSpinnerProgress.show();
			Task scoreboard = new AllScoreBoardTask(this, this.getActivity(),
					"1", "sallySyamak", 0, 10);
			AsyncTaskInvoker.RunTaskInvoker(scoreboard);
		} else {
			Toast.makeText(getActivity(), "No Internet Connection",
					Toast.LENGTH_LONG).show();
		}

	}

	private void requestFriends() {

		if (ConnectionDetector.getInstance(getActivity())
				.isConnectingToInternet()) {
			mSpinnerProgress = new ProgressDialog(getActivity());
			mSpinnerProgress.setIndeterminate(true);
			mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			mSpinnerProgress.setMessage("Loading ....");
			mSpinnerProgress.show();
			Task scoreboard = new AllScoreBoardTask(this, getActivity(), "1",
					"sallySyamak", 0, 10);
			AsyncTaskInvoker.RunTaskInvoker(scoreboard);
		} else {
			Toast.makeText(getActivity(), "No Internet Connection",
					Toast.LENGTH_LONG).show();
		}

	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_settings) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}

	@Override
	public void onStart(Task task) {
		// TODO Auto-generated method stub

	}

	@Override
	public void onFinish(Task task) {
		final ArrayList<UserData> list = UIManager.getInstance()
				.getScoreBoardArray();
		Log.d("Shaimaa", "ScoreBoardList " + list.size());

		mAdapter = new ScoreBoardAdapter(getActivity(), list);
		scoreBoardList.setAdapter(mAdapter);
		scoreBoardList.setOnItemClickListener(new OnItemClickListener() {
			@Override
			public void onItemClick(AdapterView<?> parent, View view,
					int position, long id) {
				Log.d("Shaimaa", "Id " + position);
				UserData clcikedItem = list.get(position);
				// UIManager.getInstance().startPrivalageActivity(CategoriesActivity.this);
				// finish();
			}
		});

		mSpinnerProgress.cancel();
		Log.d("Shaimaa", "ScoreBoardList " + list.size());
	}

}
