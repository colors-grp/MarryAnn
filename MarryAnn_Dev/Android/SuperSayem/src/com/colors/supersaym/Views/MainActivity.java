package com.colors.supersaym.Views;

import java.util.Arrays;

import org.json.JSONException;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Toast;

import com.colors.supersaym.R;
import com.colors.supersaym.controller.communication.AsyncTaskInvoker;
import com.colors.supersaym.controller.communication.ConnectionDetector;
import com.colors.supersaym.controller.communication.Task;
import com.colors.supersaym.controller.tasks.AddUserToScore;
import com.colors.supersaym.controller.tasks.SaveUsertoDB;
import com.colors.supersaym.dataprovider.DataRequestor;
import com.colors.supersaym.storage.Constants;
import com.colors.supersaym.storage.UIManager;
import com.facebook.Request;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.SessionLoginBehavior;
import com.facebook.SessionState;
import com.facebook.model.GraphUser;

public class MainActivity extends Activity implements DataRequestor {
	com.facebook.widget.LoginButton loginButotn;
	Activity parentActivity;
	private ProgressDialog mSpinnerProgress;
	GraphUser m_user;


	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		parentActivity=this;

		loginButotn = (com.facebook.widget.LoginButton) findViewById(R.id.loginBtn);
		
		loginButotn.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				loginFB();
			}
		});
	}

			private void loginFB() {
				
		     //   openRequest.setPermissions(Arrays.asList("user_birthday", "email"));
				 Session.StatusCallback statusCallback = new Session.StatusCallback() {

				        @Override
				        public void call(final Session session, SessionState state, Exception exception) {
				            System.out.println("GOOD");
				            if (session.isOpened()) {
				                System.out.println("AWESOME");
				                Request.executeMeRequestAsync(session, new Request.GraphUserCallback() {

				                  // callback after Graph API response with user object
				                  @Override
				                  public void onCompleted(GraphUser user,
				                      Response response) {
				                	 m_user = user;
				                	String token="";
				                	 if (response!=null) 
				                		token= session.getAccessToken();
				                	 if (user != null) {

										
										SharedPreferences appPreferences=getSharedPreferences(Constants.appPreferencesName, Context.MODE_PRIVATE);
										SharedPreferences.Editor editor = appPreferences.edit();
										editor.putString(Constants.userName, user.getName());
										editor.putString(Constants.userID, user.getId());
										editor.commit();

										Log.d("Shaimaa","User Bitrthday :"+user.getBirthday()+
												"" + appPreferences.getString(Constants.userName, ""));
										UIManager.getInstance().setName(user.getFirstName());
										UIManager.getInstance().setId(user.getId());
									UIManager.getInstance().startMainActivity(parentActivity);
                                    try {
										String email = user.getInnerJSONObject().getString("email");
									} catch (JSONException e) {
										// TODO Auto-generated catch block
										e.printStackTrace();
									}

									saveUserToDB(user,token);
				                  }
				                  }
				                });
				            }
				        }
				 };
				
				 Session session = Session.getActiveSession();
			      if (session == null) {
			          session = new Session(this);
			          Session.setActiveSession(session);
			          if (session.getState().equals(SessionState.CREATED_TOKEN_LOADED)) {
			              session.openForRead(new Session.OpenRequest(this).setCallback(statusCallback));
			          }
			      }
			      if (!session.isOpened() && !session.isClosed()) {
//			          session.openForRead(new Session.OpenRequest(this).setCallback(statusCallback));
			          
			          session.openForRead(new Session.OpenRequest(this).setCallback(statusCallback)
			        		    .setPermissions(Arrays.asList("user_birthday", "email")).setLoginBehavior(SessionLoginBehavior.SUPPRESS_SSO));

			      } else {
			          Session.openActiveSession(this, true, statusCallback);
			      }

			
		

	}
			private void saveUserToDB(GraphUser user,String token) {
				if (ConnectionDetector.getInstance(getApplicationContext())
						.isConnectingToInternet()) {
					mSpinnerProgress = new ProgressDialog(MainActivity.this);
					mSpinnerProgress.setIndeterminate(true);
					mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
					mSpinnerProgress.setMessage("Loading ....");
					mSpinnerProgress.show();
					String email="";
				if(user.getProperty("email")!=null)
					 email=user.getProperty("email").toString();


					if(email.length()==0)
					email="email.email@fb.com";
					Task task = new SaveUsertoDB(this, getApplicationContext(),
							user.getId(),user.getName(),user.getFirstName(),user.getLastName() ,user.getBirthday().replaceAll("/", "-"),email,token);
					AsyncTaskInvoker.RunTaskInvoker(task);
				} else {
					Toast.makeText(getApplicationContext(), "No Internet Connection",
							Toast.LENGTH_LONG).show();
				}				
			}

	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		Session.getActiveSession().onActivityResult(this, requestCode,
				resultCode, data);
	}

	@Override
	public void onStart(Task task) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onFinish(Task task) {
		
		if(task.getId()==Task.TaskID.SaveUserTask)
		{
			if (ConnectionDetector.getInstance(getApplicationContext())
					.isConnectingToInternet()) {
				mSpinnerProgress = new ProgressDialog(MainActivity.this);
				mSpinnerProgress.setIndeterminate(true);
				mSpinnerProgress.setProgressStyle(ProgressDialog.STYLE_SPINNER);
				mSpinnerProgress.setMessage("Loading ....");
				mSpinnerProgress.show();
			
				Task addUserCategories = new AddUserToScore(this, getApplicationContext(), m_user.getId(),m_user.getName());
				AsyncTaskInvoker.RunTaskInvoker(task);
			} else {
				Toast.makeText(getApplicationContext(), "No Internet Connection",
						Toast.LENGTH_LONG).show();
			}				
		}
	}
}
