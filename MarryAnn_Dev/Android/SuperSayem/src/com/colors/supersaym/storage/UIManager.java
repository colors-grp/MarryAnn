package com.colors.supersaym.storage;

import java.security.PublicKey;
import java.util.ArrayList;

import android.app.Activity;
import android.content.Intent;

import com.colors.supersaym.dataobjects.UserData;
import com.colors.supersaym.tabs.HomeActivity;

public class UIManager {

	private static UIManager instance = new UIManager();
	private String mSallySyamakScore, mMosalslatScore, MmanElQatel, MShahryar;
	private ArrayList<UserData>scoreBoardArray;
	public static String accountId="accountId";
	public ArrayList<UserData> getScoreBoardArray() {
		return scoreBoardArray;
	}

	public void setScoreBoardArray(ArrayList<UserData> scoreBoardArray) {
		this.scoreBoardArray = scoreBoardArray;
	}

	private String name, Id;

	public String getId() {
		return Id;
	}

	public void setId(String id) {
		Id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public String getmSallySyamakScore() {
		return mSallySyamakScore;
	}

	public void setmSallySyamakScore(String mSallySyamakScore) {
		this.mSallySyamakScore = mSallySyamakScore;
	}

	public String getmMosalslatScore() {
		return mMosalslatScore;
	}

	public void setmMosalslatScore(String mMosalslatScore) {
		this.mMosalslatScore = mMosalslatScore;
	}

	public String getMmanElQatel() {
		return MmanElQatel;
	}

	public void setMmanElQatel(String mmanElQatel) {
		MmanElQatel = mmanElQatel;
	}

	public String getMShahryar() {
		return MShahryar;
	}

	public void setMShahryar(String mShahryar) {
		MShahryar = mShahryar;
	}

	private UIManager() {

	}

	public static UIManager getInstance() {
		return instance;
	}

	public void startMainActivity(Activity parentActivity) {
		Intent intent = new Intent(parentActivity, HomeActivity.class);
		parentActivity.startActivity(intent);
	}

}
