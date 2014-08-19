package com.colors.supersaym.Views;



import com.colors.supersaym.R;
import com.colors.supersaym.R.layout;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.tabs.HomeActivity;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;

public class SplashActivity extends Activity {

	// Splash screen timer
	private static int SPLASH_TIME_OUT = 3000;
	SharedPreferences appPreferences;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_splash);
		appPreferences = getSharedPreferences(Constants.appPreferencesName,
				Context.MODE_PRIVATE);
//		if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.HONEYCOMB) {
//			getActionBar().hide();
//		}
		new Handler().postDelayed(new Runnable() {

			/*
			 * Showing splash screen with a timer. This will be useful when you
			 * want to show case your app logo / company
			 */

			@Override
			public void run() {
				// This method will be executed once the timer is over
				// Start your app main activity
				if (!appPreferences.contains(Constants.userName)) {
					Intent i = new Intent(SplashActivity.this,
							MainActivity.class);
					startActivity(i);
				} else {
					Intent i = new Intent(SplashActivity.this,
							HomeActivity.class);
					startActivity(i);
				}

				// close this activity
				finish();
			}
		}, SPLASH_TIME_OUT);
	}
}
