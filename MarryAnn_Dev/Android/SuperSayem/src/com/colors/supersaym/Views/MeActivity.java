package com.colors.supersaym.Views;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.colors.supersaym.R;
import com.colors.supersaym.controller.communication.AsyncTaskInvoker;
import com.colors.supersaym.controller.communication.ConnectionDetector;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.tasks.MeScoreBoardTask;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.storage.UIManager;

public class MeActivity extends Fragment implements DataRequestor {

	TextView headerTxt, userName, mosalast, mnlqatel, sallyseyamk,games;
	private ProgressDialog mSpinnerProgress;
	private View rootView;

	SharedPreferences appPreferences;
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.acitivy_layout, container, false);

		 appPreferences = getActivity().getSharedPreferences(
				Constants.appPreferencesName, Context.MODE_PRIVATE);

		headerTxt = (TextView) rootView.findViewById(R.id.header_txt);
		headerTxt.setText(R.string.me);

		userName = (TextView) rootView.findViewById(R.id.name);
		if (appPreferences.contains(Constants.userName)) {

			userName.setText(appPreferences.getString(Constants.userName, ""));
			Log.d("Shaimaa",
					"FB USerID "
							+ appPreferences.getString(Constants.userID, ""));

		}
		mosalast = (TextView) rootView.findViewById(R.id.alfScore);
		sallyseyamk = (TextView) rootView.findViewById(R.id.sallyseyamk);
		mnlqatel = (TextView) rootView.findViewById(R.id.killer);
		games=(TextView)rootView.findViewById(R.id.games);
		requestData();
		return rootView;
	}

	private void requestData() {

		if (ConnectionDetector.getInstance(getActivity())
				.isConnectingToInternet()) {
			mSpinnerProgress = new ProgressDialog(getActivity());
			mSpinnerProgress.setIndeterminate(true);
			mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
			mSpinnerProgress.setMessage("Loading ....");
			mSpinnerProgress.show();
			Task task = new MeScoreBoardTask(this, getActivity(),appPreferences.getString(Constants.userID, ""));
			AsyncTaskInvoker.RunTaskInvoker(task);
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

	}

	@Override
	public void onFinish(Task task) {
		mnlqatel.setText(UIManager.getInstance().getMmanElQatel());
		mosalast.setText(UIManager.getInstance().getmMosalslatScore());
		sallyseyamk.setText(UIManager.getInstance().getmSallySyamakScore());
		mSpinnerProgress.cancel();

	}

}
